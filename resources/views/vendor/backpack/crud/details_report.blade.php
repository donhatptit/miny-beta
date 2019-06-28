<div class="m-t-10 m-b-10 p-l-10 p-r-10 p-t-10 p-b-10">
	<div class="row">
		<div class="col-md-12">
			@if(count($entry->reason) > 0)
			<p class="text-bold">Lý do :</p>
				<ul>
					@foreach($entry->reason as $reason)
						<li class="text-red"> {{ $reason }}</li>
						@endforeach
				</ul>
				@endif
				<p class="text-bold">Mô tả :</p>
				<p>{{ $entry->description or "Không có" }}</p>
		</div>
	</div>
</div>
<div class="clearfix"></div>