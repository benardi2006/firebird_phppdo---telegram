$.ajax({
	type:"GET",
	datatype :"json",
	url: "_PROSES/user_proses?action=datapenjualan",
	success: function(data) {
		//console.log(data);
		var hasil = JSON.parse(data);
		var datatgl = hasil.penjualan.map(function(e) {
			return e.TGL;
		 });
		var datapenjualan = hasil.penjualan.map(function(e) {
			return e.JUMLAH;
		 });

		var chartdata = {
			labels: datatgl,
			datasets:[{
				responsive : true,
				label: 'Tanggal Penjualan',
				data: datapenjualan,
				backgroundColor: ['rgba(255, 99, 132, 0.2)'],
				borderColor: ['rgba(255,99,132,1)'],
				borderWidth: 1
			}]
		};
		if (datatgl == null || datapenjualan == null)
		{
			return setTimeout(function(){ myChart}, 200);
		}
		var ctx = document.getElementById("line-chart").getContext('2d');
		var myChart = new Chart(ctx, {
			type: 'line',
			data: chartdata,
			options: {        
				legend: {display: false},
				scales: {
					yAxes: [{
						ticks: {
							// Include a dollar sign in the ticks
							callback: function(value, index, values) 
								{
								return parseFloat(value).toLocaleString();
								}
							}
						}],
					xAxes: [{
							ticks: {
								// Include a dollar sign in the ticks
								callback: function(value, index, values) 
									{
									return value;
									}
							}
						}]
					}
				} 		
			});
			
	},
	error: function(data) {
		console.log(data);
	}
});