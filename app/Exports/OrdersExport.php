<?php

namespace App\Exports;

use App\Model\Order;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\AfterSheet;

class OrdersExport implements FromView, WithHeadings, ShouldAutoSize, WithEvents
{
	public function __construct($yr, $mt, $us)
	{
		$this->yr 	= $yr;
		$this->mt 	= $mt;
		$this->us 	= $us;
	}
	public function View() : View
	{
		return view('admin.report.excel',[
			'orders' => Order::where([
				'created_by' => $this->us
			])->get()
		]);
	}
	public function headings(): array
	{
		return [
			'No.',
			'Nomor Meja',
			'Pembayaran',
			'Total',
			'Kasir',
			'Dibeli pada',
		];
	}
	public function registerEvents(): array
	{
		return [
			AfterSheet::class 	=> function(AfterSheet $event){
				$cellRange = 'A1:W1';
				$event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
				$spreadsheet->getActiveSheet()->getStyle('A1:D4')->getAlignment()->setWrapText(true);
				$spreadsheet->getDefaultStyle()->getFont()->setName('Arial');
				$spreadsheet->getDefaultStyle()->getFont()->setSize(8);
				$styleArray = [
			    'borders' => [
			        'outline' => [
			            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
			            'color' => ['argb' => 'FFFF0000'],
			        	],
			    	],
				];
				$worksheet->getStyle('B2:G8')->applyFromArray($styleArray);
			},
		];
	}
}
