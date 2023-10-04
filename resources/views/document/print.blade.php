<!DOCTYPE html>
<html>
	<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>fc9 Print</title>
		<link href="{{asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
		<style>
		@import url('https://fonts.googleapis.com/css2?family=Noto+Naskh+Arabic&family=Noto+Sans&display=swap');
		h1, h2, h3, h4, h5, h6 {
			font-family: 'Noto Naskh Arabic', serif, 'Noto Sans', sans-serif;
		}
    	body {font-family: 'Noto Naskh Arabic' !important; font-size:11px;}
			.invoice-box {
				max-width: 800px;
				margin: auto;
				font-size: 13px;
				line-height: 24px;
				color: #555;
				font-family: 'Noto Naskh Arabic', serif, 'Noto Sans', sans-serif;
				
			}			

			@media only screen and (max-width: 600px) {
				.invoice-box table tr.top table td {
					width: 100%;
					display: block;
					text-align: center;
				}

				.invoice-box table tr.information table td {
					width: 100%;
					display: block;
					text-align: center;
				}

			}

			/** RTL **/
			.invoice-box.rtl {
				direction: rtl;
			}

			.invoice-box.rtl table {
				text-align: right;
			}

			.invoice-box.rtl table tr td:nth-child(2) {
				text-align: left;
			}
            .title2, .title1{text-align:center !important}
            .title2{text-align:right}
            .title2 h2{margin-bottom: 0;font-size: 20px;font-weight: 600;}
            .title2 h4{margin-top: 5px;font-size: 18px;font-weight: 500;}
            .title1 h2{margin-bottom:0}
            .title1 h4{margin-top:0;}
            .title3 img{margin-left:auto; margin-right:auto; display:block;}
            .title3 div{text-align:center;}
            .htmltb tr td {border: 1px solid #ccc; border-collapse: collapse;font-size: 12px;width: auto;}
            .htmltb th{border: 1px solid #ccc;border-collapse: collapse;font-size:11px}
            .htmltb{text-align: center !important;padding: 5px;direction: rtl; width:100%}
            .smalltext{height:10px; background:#f9f9f9;}
            .note, .notices{direction:rtl}
			.number-row td {padding: 0 !important;text-align: center;font-size: 11px;}
			.main-td {padding: 10px !important;text-align: right !important;}
		</style>
	</head>

	<body>
		<div class="invoice-box">
					<div class="row">
						<div class="d-flex justfiy-content-between">
							<div class="col title2 mt-4">
								<h2>امارت اسلامی افغانستان</h2>
									<h4>وزارت مالیه</h4>
									<div class="mt-4"><span style="direction:rtl; float:right"> {{__('fc9.request_rep')}}</span>  {{$fc9->dir_name}}</div>
									<div class="text-center"><span style="direction:rtl; float:right">{{__('fc9.name_of_representative')}}</span></div>
							</div>
							<div class="col title3">
								<img src="{{asset('assets/images/logo-icon.png') }}" style="width: 80px; max-width: 300px; margin-left: auto;margin-right: auto;display: block;">
								<div>{{__('fc9.fc9_form')}}</div>
								<div>{{__('fc9.dilevery_request')}}</div>
								<div >فرمایش ترمیم   </div>
							</div>
							<div class="col title2  mt-4">
								<h2>د افغانستان اسلامي امارت</h2>
									<h4 class="mb-4">د مالیې وزارت</h4>
									<div>{{$fc9->fecen9_number}} <span style="direction:rtl; float:right">{{__('fc9.number')}}</span>   </div>
									<div>  {{$fc9->issue_date}}  <span style="direction:rtl; float:right">{{__('fc9.date')}}</span></div>
							</div>
						</div>
					</div>
					<hr class="m-0">
				<table class="htmltb">
                    <thead class="table-light">
                        <tr>
							<th>{{__('fc9.item_number')}}</th>
							<th>{{__('fc9.reserve_number')}}</th>
							<th style="width: 50%">{{__('fc9.item_details_services')}}</th>
							<th>{{__('fc9.amount')}}</th>
							<th>{{__('fc9.unit')}}</th>
							<th>{{__('fc9.added_to_the_account')}}</th>
                        </tr>
						<tr class="number-row">
							<td>5</td>
							<td>6</td>
							<td>7</td>
							<td>8</td>
							<td>9</td>
							<td>10</td>
						</tr>
                    </thead>
                    <tbody>
                        <!-- Small Text under the Head section -->
                        <tr class="smalltext">
                            <td></td>
                            <td></td>
                            <td>
							<div class="main-td">
								<b>{{__('fc9.fc9_md')}}</b>
								<p>{{$fc9->remark}}</p>
							@foreach($items as $item)
								<p>{{ $loop->index+1 }}- {{$item->name}}: {{$item->item_specification}}, {{$item->quantity}} {{$item->measure}}
								<span>در وجه محترم {{$item->employee}} {{__('general_words.son')}} {{$item->employee_father_name}}.</span>
								@if($item->year)<span>سال: {{$item->year}}, ماه: {{$item->month}}, شاسی: {{$item->chassis}} ,پلت: {{$item->number_palate}},انجن: {{$item->engine}},سجل نمبر: {{$item->sejel_number}} </span>@endif
								</p>
							@endforeach
							@if(!$item->year && $items[0]->chassis)
							<p>نمبر سجل: {{$items[0]->sejel_number}}</p>
							<p>نمبر شاسی: {{$items[0]->chassis}}</p>
							@endif
							</div>
							<div>
							</div>
							</br>
							با احترام
							</br>
							{{$items[0]->chassis ? __('general_words.transport_office'): $fc9->dir_name}}
							</br>
							</br>
							</br>
							</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
                <!-- Main Table closed -->
            <div class="note" style="position: relative">
                    <ul>
                        <li>{{__('fc9.Items_marked_not_available_buyers_should_request')}}</li>
                        <li>{{__('fc9.ticket_destribution_number')}}(                    )</li>
						<li>{{__('fc9.signature')}}__________________</li>
                        <li> {{__('fc9.sub_director')}}__________________ <span>{{__('fc9.date')}}: ـــــــــــــــــ</span></li>
                        
                    </ul>
					<span style="float:left; float: left;position: absolute;top: 0;left: 0;
							margin-top: 5px;" class="mb-2">
						{{-- {!! DNS1D::getBarcodeHTML('hi','C128', 1, 50) !!} --}}
						{!! QrCode::encoding('UTF-8')->generate(url()->current()) !!}					</span>
                </div>
            <div class="notices">
                <div class="notice">
                    <ul>
                        <li>{{__('fc9.Distribution_One_original_and_two_copies_are_combined')}}</li>
                        <li>{{__('fc9.the_original_will_be_kept_at_the_delivery_house.')}} {{__('fc9.sending_copy')}} {{__('fc9.second_copy')}}</li>

                    </ul>
                </div>
            </div>
		</div>
	</body>
</html>
