<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use League\Csv\Reader;
use App\Model\Product;
use File;
class ImportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $filename;
    public function __construct($filename)
    {
        $this->filename = $filename;
    }
    public function handle()
    {
        $csv = Reader::createFromPath(storage_path('app/public/import/' . $this->filename), 'r');
        //BARIS PERTAMA DI-SET SEBAGAI KEY DARI ARRAY YANG DIHASILKAN
        $csv->setHeaderOffset(0);
        
        //LOOPING DATA YANG TELAH DI-LOAD
        foreach ($csv as $row) {
            //SIMPAN KE DALAM TABLE USER
            Product::create([
                'created_at' => $row['created_at'],
                'updated_at' => $row['updated_at']
            ]);
        }
        //APABILA PROSES TELAH SELESAI, FILE DIHAPUS.
        File::delete(storage_path('app/public/import/' . $this->filename));
    }
}

