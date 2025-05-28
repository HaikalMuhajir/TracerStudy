<?php

namespace App\Imports;

use App\Models\Alumni;
use App\Models\ProgramStudi;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Mail;
use App\Mail\TracerStudyLinkMail;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Log;

class AlumniImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $prodi = ProgramStudi::where('nama_prodi', $row['prodi'])->first();
            if (!$prodi) continue;

            $alumni = Alumni::create([
                'nama' => $row['nama'],
                'nim' => $row['nim'],
                'no_hp' => $row['no_hp'],
                'email' => $row['email'],
                'tanggal_lulus' => $this->transformDate($row['tanggal_lulus'] ?? null),
                'prodi_id' => $prodi->prodi_id,
                'token' => Str::random(32),
            ]);

            $link = url('/form-alumni/' . $alumni->token);

            if ($alumni->email) {
                Mail::to($alumni->email)->send(new TracerStudyLinkMail($alumni, $link));
            }

            $message = "*Halo {$alumni->nama}* 👋

Kami dari *Tim Tracer Study POLINEMA* mengundang Anda untuk berpartisipasi dalam pengisian *Tracer Study Alumni*.

📝 Silakan isi formulir melalui link berikut:
{$link}

Partisipasi Anda sangat berarti untuk pengembangan institusi dan peningkatan kualitas lulusan.

Terima kasih atas waktunya 🙏
Salam hormat,
*Tim Tracer Study POLINEMA*";

            if ($alumni->no_hp) {
                $this->sendWhatsAppMessage($alumni->no_hp, $message);
            }
        }
    }


    private function transformDate($excelDate)
    {
        try {
            return Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($excelDate))->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }

    private function sendWhatsAppMessage($toNumber, $message)
    {
        $sid = env('TWILIO_SID');
        $token = env('TWILIO_AUTH_TOKEN');
        $twilioNumber = env('TWILIO_WHATSAPP_FROM');

        $client = new Client($sid, $token);

        try {
            $client->messages->create(
                "whatsapp:+62" . ltrim($toNumber, '0'),
                [
                    'from' => $twilioNumber,
                    'body' => $message
                ]
            );
        } catch (\Exception $e) {
            Log::error("Gagal kirim WA ke {$toNumber}: " . $e->getMessage());
        }
    }
}
