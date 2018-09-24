var ldate = '';
var ltime = '';
var fdate = '';
var sens = 0;
var corps = 0;
var rows = 0;
var hangs = 0;
var col = ["#1F77B4","#FF7F0E","#2CA02C","#D62728","#9467BD","#FF00DC","#FFD200","#9B3B00","#000000","#9B3B00"];
var lineType = ["line", "smoothedLine", "column", "step", "candlestick", "ohlc"];
var chartData = [];
var tempData = [];
var minYval = 0;
var maxYval = 60;
var t_red = 60.0;
var t_blue = 0.0;
var hnum = 0;
var corpnum = 0;
var htitle = '';
var dt = null;

$(document).ready(function(){

	setTempCol();

	document.getElementById("minY").value = minYval;
	document.getElementById("maxY").value = maxYval;
	document.getElementById("minYgr").value = minYval;
	document.getElementById("maxYgr").value = maxYval;
	document.getElementById("minYsingle").value = minYval;
	document.getElementById("maxYsingle").value = maxYval;

// ------------------------------------------------------

	$("#minY").blur(function(){
		var setMin = parseInt($(this).val());
		if(setMin<-50){
			setMin = -50;
		}
		else if(setMin>maxYval){
			setMin = maxYval-10;
		}
		minYval = setMin;
		document.getElementById("minY").value = minYval;
		document.getElementById("minYgr").value = minYval;		
		document.getElementById("minYsingle").value = minYval;
			var row = document.getElementById('rowid').value;
			var corp = document.getElementById('corpid').value;
			var hang = document.getElementById('hangid').value;
			if(row!=0 && corp!=0 && hang!=0){
				createStockChart(document.getElementById('chartdiv'));
			}
	});

	$("#maxY").blur(function(){
		var setMax = parseInt($(this).val());
		if(setMax>150){
			setMax = 150;
		}
		else if(setMax<minYval){
			setMax = minYval+10;
		}
		maxYval = setMax;
		document.getElementById("maxY").value = maxYval;
		document.getElementById("maxYgr").value = maxYval;		
		document.getElementById("maxYsingle").value = maxYval;
			var row = document.getElementById('rowid').value;
			var corp = document.getElementById('corpid').value;
			var hang = document.getElementById('hangid').value;
			if(row!=0 && corp!=0 && hang!=0){
				createStockChart(document.getElementById('chartdiv'));
			}
	});
// ----------------- group -----------------------------------
	$("#minYgr").blur(function(){
		var setMin = parseInt($(this).val());
		if(setMin<-50){
			setMin = -50;
		}
		else if(setMin>maxYval){
			setMin = maxYval-10;
		}
		minYval = setMin;
		document.getElementById("minY").value = minYval;
		document.getElementById("minYgr").value = minYval;
		document.getElementById("minYsingle").value = minYval;
			var row = document.getElementById('rowid').value;
			var corp = document.getElementById('corpid').value;
			var hang = document.getElementById('hangid').value;
		createStockChart(document.getElementById('chartGrdiv'));
	});

	$("#maxYgr").blur(function(){
		var setMax = parseInt($(this).val());
		if(setMax>150){
			setMax = 150;
		}
		else if(setMax<minYval){
			setMax = minYval+10;
		}
		maxYval = setMax;
		document.getElementById("maxY").value = maxYval;
		document.getElementById("maxYgr").value = maxYval;		
		document.getElementById("maxYsingle").value = maxYval;
			var row = document.getElementById('rowid').value;
			var corp = document.getElementById('corpid').value;
			var hang = document.getElementById('hangid').value;
		createStockChart(document.getElementById('chartGrdiv'));
	});	
// ---------------- single ------------------------------------
	$("#minYsingle").blur(function(){
		var setMin = parseInt($(this).val());
		if(setMin<-50){
			setMin = -50;
		}
		else if(setMin>maxYval){
			setMin = maxYval-10;
		}
		minYval = setMin;
		document.getElementById("minY").value = minYval;
		document.getElementById("minYgr").value = minYval;		
		document.getElementById("minYsingle").value = minYval;
		createSingleChart();
	});

	$("#maxYsingle").blur(function(){
		var setMax = parseInt($(this).val());
		if(setMax>150){
			setMax = 150;
		}
		else if(setMax<minYval){
			setMax = minYval+10;
		}
		maxYval = setMax;
		document.getElementById("maxY").value = maxYval;
		document.getElementById("maxYgr").value = maxYval;		
		document.getElementById("maxYsingle").value = maxYval;
		createSingleChart();
	});
// -----------------------------------------------------
	document.getElementById("trn").addEventListener("click", () => {
	    showTrend();
	});

	document.getElementById("sett").addEventListener("click", () => {
	    $('#ColorSet').modal("show");
	});

	document.getElementById("upd").addEventListener("click", () => {
	    brake();
	});

	document.getElementById("conf").addEventListener("click", () => {
	    setColTemp();
	});

	document.getElementById("selGrTrend").addEventListener("click", () => {
	    showGrTrend();
	});

	document.getElementById("canc").addEventListener("click", () => {
	    setTempCol();
	});

	document.getElementById("back").addEventListener("click", () => {
	    ScrollToMark('#siteheader');
	});

// ----------
    $("#datepicker").datepicker({
		dateFormat: "yyyy-mm-dd",
		duration: "slow",
		dayNamesMin: [ "Нд", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб" ],
		monthNames: [ "Січень", "Лютий", "Березень", "Квітень", "Травень", "Червень", "Липень", "Серпень", "Вересень", "Жовтень", "Листопад", "Грудень" ],
		maxLength:10
	});
// ----------
    ltime = document.getElementById('ldate').innerHTML.substring(11,19);
    if(ltime.length == 0) ltime = "00:00:00";
	ldate = document.getElementById('ldate').innerHTML.substring(0,10);
	fdate = document.getElementById('fdate').innerHTML.substring(0,10);
	datepicker.value = ldate;
	seltime.value = ltime;
// ----------
	$('[data-toggle="tooltip"]').tooltip();
// ----------
	sens = parseInt(document.getElementById('sens').innerHTML);
	for (var i = sens; i >= 1; i--){		
		$("table[name='modalTblName']").append("<tr><td>Датчик "+i+"</td><td><div class='wdata' id='num"+i+"'></div></td></tr>");
	}
// ----------	
	corps = parseInt(document.getElementById('corps').innerHTML);
	for(i = 0; i<corps; i++){
		$("select[name='corpname']").append("<option value="+parseInt(i+1)+">Силкорпус "+parseInt(i+1)+"</option>");
	}
// ----------	
	rows = parseInt(document.getElementById('rows').innerHTML);
	for(i = 0; i<rows; i++){
		$("select[name='rowname']").append("<option value="+parseInt(i+1)+">Ряд "+parseInt(i+1)+"</option>");
	}
// ----------	
	hangs = parseInt(document.getElementById('hangs').innerHTML);
	for(i = 1; i<=hangs; i++){
		$("select[name='hangname']").append("<option value="+i+" id='selh"+i+"'><span id='selh"+i+"'>Силос "+i+"</option>");
	}
// ----------
	initCol();
// ----------
	dt = setInterval("update()",3600000);
//
});
// ----------------------------------------
// ******* F U N C T I O N S *******
// ----------------------------------------
function brake(){
	var updbox = document.getElementById('upd').checked;
	if(updbox==false){
		clearInterval(dt);
	}
	else{
		dt = setInterval("update()",3600000);
	}
}
// ----------------------------------------
function update(){
	window.location.reload();
}
// ----------------------------------------
function setCol(val){

	var Xmax = t_red;
	var Xmin = t_blue;
	var Ymin = 250;
	var Ymax = 0;

	var k = (Ymax - Ymin)/(Xmax-Xmin);
	var b = Ymin - Xmin*k;
	var col = "";
	if (val=='n/a' || val=='NaN'){
		//return col = "hsl(10,100%,50%)";
		return col = "#999999";
	}
	else{
		var h = k*val + b;
		return col = 'hsl('+h+',100%,65%)';
	}
}
// ----------------------------------------
function initCol(){
	var tab = document.getElementsByClassName('hdata');
	for(var id in tab){
		var elem = tab[id];
		if(elem.innerHTML!=null)
			elem.style.backgroundColor = setCol(elem.innerHTML);
	}
	var stab = document.getElementsByClassName('shdata');
	for(var id in stab){
		elem = stab[id];
		if(elem.innerHTML!=null)
			elem.style.backgroundColor = setCol(elem.innerHTML);
	}
	var maxtab = document.getElementsByClassName('maxdata');
	for(var id in maxtab){
		elem = maxtab[id];
		if(elem.innerHTML!=null)
			elem.style.backgroundColor = setCol(elem.innerHTML);
	}

/*
	var xcell = document.getElementsByClassName('sil_cell');
	for(var id in xcell){
		elem = xcell[id];
		if(elem.innerHTML!=null)
			elem.style.backgroundColor = setCol(elem.innerHTML);
	}
*/

	var xcell = document.getElementsByClassName('silcorp');
	for(var id in xcell){
		elem = xcell[id];	
		if(elem.innerHTML!=null){
			var maxval = document.getElementById('max' + id).innerHTML;
			elem.style.backgroundColor = setCol(maxval);
		}
	}

}
// ----------------------------------------
function ScrollToMark(linkname){
	$('html, body').animate({scrollTop:$(linkname).offset().top}, 1200);
}
// ----------------------------------------
function showHang(silname,row,hang){
	var temp = [];
		hnum = row*hangs + hang + 1;
		corpnum = Math.floor(row/(corps+1))+1;
		htitle = 'Силос ' + silname;
	var sname = '';
	for(var i = 0; i < sens; i++){
		sname = 'hdata' + hnum.toString() + parseInt(i + 1);
		temp[i] = parseFloat(document.getElementById(sname).innerHTML);
	}
	$('#tempModal').modal("show");
	document.getElementById('tblname').innerHTML = htitle;
		for(var i=1;i<=temp.length;i++){
			var elem = document.getElementById('num'+i.toString());
			elem.innerHTML = temp[i-1];
		}
	var wtab = document.getElementsByClassName('wdata');
	for(var id in wtab){
		var elem = wtab[id];
		if(elem.innerHTML!=null)
			elem.style.backgroundColor = setCol(elem.innerHTML);
	}
}
// ----------------------------------------
function anim(){
	var tr = document.getElementsByClassName('t1');
	for(var id in tr){
		var elem = tr[id];
		if(elem.innerHTML!=null){
			elem.className += ' anim';
		}
	}
	var tl = document.getElementsByClassName('t0');
	for(var id in tl){
		var elem = tl[id];
		if(elem.innerHTML!=null){
			elem.className += ' anim';
		}
	}
}
// ----------------------------------------
function GoToDate(){
	alert('OK...');
}
// ----------------------------------------
function myDateFmt(val){
	var ret = "";
	var year = val.substring(0,4);
	var month = val.substring(5,7);
	var day = val.substring(8);
		ret = day+"."+month+"."+year;
	return ret;
}
// ----------------------------------------
function revMyDateFmt(val){
	var ret = "";
	var year = val.substring(6);
	var month = val.substring(3,5);
	var day = val.substring(0,2);
		ret = year+"-"+month+"-"+day;
	return ret;
}
// ----------------------------------------
function autofmt(elem){	
	var strlen = elem.value.length;
	var max = parseInt(ldate.substring(ldate.length-2,ldate.length));
	var min = parseInt(fdate.substring(fdate.length-2,fdate.length));
	var last = parseInt(elem.value.substring(strlen-2,strlen));
		elem.value = elem.value.substring(strlen-10,strlen);
}
// ----------------------------------------
function showTrend(){
	$('#trendModal').modal("show");
}
// ----------------------------------------
function selHang(){
	var row = document.getElementById('rowid').value;
	var corp = document.getElementById('corpid').value;

	if(corp == 0){
		alert('Виберіть силкорпус');
	}
	else if(row!=0){
		$("#hangid").val("0").change();
		$.ajax({
			url:"prep.php",
			type:"POST",
			data:({
				selrow:row,
				selcorp:corp
			}),
			dataType:"html",
			success:function(data){
				data = JSON.parse(data);		
				var i = 1;	
				for(var id in data){
					var silnum = data[id]%hangs;
					if(silnum==0)silnum=hangs;
				//	document.getElementById('selh' + i).innerHTML = 'Силос ' + corp + row + '0' + silnum;
						if(silnum<10){
							document.getElementById('selh' + i).innerHTML = 'Силос ' + corp + row + '0' + silnum;
						}
						else{
							document.getElementById('selh' + i).innerHTML = 'Силос ' + corp + row + silnum;
						}
					//	document.getElementById('selh' + i).innerHTML = 'Силос ' + data[id];
					document.getElementById('selh' + i).value = data[id];
					i++;
				}
					
			}
		});
	}
}
// ----------------------------------------
	function selTrend(elem){
		tempData = [];
		var val = elem.value;
		if(val!=0){
			$.ajax({
				url:"getdata.php",
				type:"POST",
				data:({selhang:val}),
				dataType:"html",
				success:function(data){
					data = JSON.parse(data);
					for(var id in data){
						tempData[id] = [];
						for(var i in data[id]){
							tempData[id][i] = data[id][i];
						}
					}
					//setTrendData();
					setTrendData(document.getElementById('chartdiv'));
				}
			});
		}
	}
// ----------------------------------------
	function setTrendData(elem){
		var el = elem;
		chartData = [];
		for(var i = 0; i < tempData[0].length; i++){
			chartData.push({
				value0:tempData[0][i],
				value1:tempData[1][i],
				value2:tempData[2][i],
				value3:tempData[3][i],
				value4:tempData[4][i],
				value5:tempData[5][i],
				value6:tempData[6][i]
			//	value7:tempData[7][i],
			//	value8:tempData[8][i]
			});
		}
		createStockChart(el);		
	}
// ----------------------------------------
	function createStockChart(elem) {
        $(elem.id).fadeOut("slow");
	var chart = new AmCharts.AmStockChart();
		/*
			chart["export"] = {
			  "enabled": true
			};
		*/
		var categoryAxesSettings = new AmCharts.CategoryAxesSettings();
		categoryAxesSettings.minPeriod = "ss";
		chart.categoryAxesSettings = categoryAxesSettings;

		var valueAxesSettings = new AmCharts.ValueAxesSettings();
		valueAxesSettings.minimum = minYval;
		valueAxesSettings.maximum = maxYval;
		chart.valueAxesSettings = valueAxesSettings;


		var dataSet = new AmCharts.DataSet();

		dataSet.dataProvider = chartData;
		dataSet.categoryField = "value0";
				
		dataSet.fieldMappings = [
			{fromField: "value1", toField: "value1"},
			{fromField: "value2", toField: "value2"},
			{fromField: "value3", toField: "value3"},
			{fromField: "value4", toField: "value4"},
			{fromField: "value5", toField: "value5"},
			{fromField: "value6", toField: "value6"}
		//	{fromField: "value7", toField: "value7"},
		//	{fromField: "value8", toField: "value8"}
		];
				
		chart.dataSets = [dataSet];
		
		var stockPanel1 = new AmCharts.StockPanel();
			stockPanel1.showCategoryAxis = true;
			stockPanel1.title = "Температура,°C";
			stockPanel1.percentHeight = 70;
				
		var graph = [];

		for(var i=1;i < tempData.length;i++){
			if(tempData[i].length != 0){
				graph[i] = new AmCharts.StockGraph();
				graph[i].title = "Датчик " + parseInt(i);
				graph[i].balloonText = "[[title]]:[[value]]°C";
				graph[i].useDataSetColors = false;
				graph[i].lineColor = col[i-1];
				graph[i].valueField = "value" + parseInt(i);;
				graph[i].type = lineType[1]; // 0 - line, 1 - smoothedLine, 2 - column, 3 - step, 4 - candlestick, 5 - ohlc
				graph[i].lineThickness = 2;
				graph[i].bullet = "round";
				graph[i].bulletSize = 2;
				graph[i].bulletBorderColor = "white";
				graph[i].bulletBorderAlpha = 1;
				graph[i].bulletBorderThickness = 0;
				graph[i].id = parseInt(i);
				stockPanel1.addStockGraph(graph[i]);
			}
		}
	
		var stockLegend1 = new AmCharts.StockLegend();
			stockLegend1.valueTextRegular = " ";				
			stockPanel1.stockLegend = stockLegend1;	
				
			chart.panels = [stockPanel1];

		var scrollbarSettings = new AmCharts.ChartScrollbarSettings();
			scrollbarSettings.graph = graph[1];
			scrollbarSettings.usePeriod = "10mm";
			scrollbarSettings.updateOnReleaseOnly = false;
			scrollbarSettings.position = "bottom";
			
			chart.chartScrollbarSettings = scrollbarSettings;

		var cursorSettings = new AmCharts.ChartCursorSettings();
			cursorSettings.showNextAvailable = true;
			cursorSettings.cursorColor = "red";
			cursorSettings.valueLineEnabled = false; // true
			cursorSettings.valueLineAlpha = 0.5;
			cursorSettings.categoryBalloonDateFormats = [
				{period:"YYYY", format:"YYYY"},
				{period:"MM", format:"MMM, YYYY"},
				{period:"WW", format:"DD MMM YYYY"},
				{period:"DD", format:"DD MMM YYYY"},
				{period:"hh", format:"DD MMM, JJ:NN:SS"},
				{period:"mm", format:"DD MMM, JJ:NN:SS"},
				{period:"ss", format:"DD MMM, JJ:NN:SS"},
				{period:"fff", format:"JJ:NN:SS"}]; // "fff"-milliseconds
			cursorSettings.valueBalloonsEnabled = true;
			cursorSettings.fullWidth = true;
			cursorSettings.cursorAlpha = 0.1;
			
			chart.chartCursorSettings = cursorSettings;

		var periodSelector = new AmCharts.PeriodSelector();
			periodSelector.position = "bottom";
			periodSelector.dateFormat = "YYYY-MM-DD JJ:NN";
			periodSelector.inputFieldWidth = 180;
			periodSelector.periods = [
				{
					period: "DD",
					selected: true,
					count: 3,
					label: "3 дні"
				}, {
					period: "DD",
					count: 5,
					label: "5 днів"
				}, {
					period: "MM",
					count: 1,
					label: "1 місяць"
				}, {
					period: "YYYY",
					count: 1,
					label: "1 рік"
				}, {
					period: "MAX",
					label: "MAX"
				}];
			chart.periodSelector = periodSelector;

		var panelsSettings = new AmCharts.PanelsSettings();
			panelsSettings.mouseWheelZoomEnabled = true;
				
			panelsSettings.usePrefixes = true;
		chart.panelsSettings = panelsSettings;
		chart.write(elem.id);
		$(elem.id).fadeIn("slow");
}
// ----------------------------------------
function showSingle(silnum, silo, sens){
	$('#trendSinle').modal("show");
	document.getElementById('sensor').innerHTML = sens;
	document.getElementById('silo').innerHTML = silnum;

//	console.log('selhang = '+silo+'; slsens = ' + sens);
//	return;

		tempData = [];
		if(silo!=0 && sens!=0){
			$.ajax({
				url:"getsingle.php",
				type:"POST",
				data:(
					{
						selhang:silo,
						selsens:sens
					}
				),
				dataType:"html",
				success:function(data){
					data = JSON.parse(data);
					for(var id in data){
						tempData[id] = [];
						for(var i in data[id]){
							tempData[id][i] = data[id][i];
						}
					}
					setSingleData();
				}
			});
		}
}
// ----------------------------------------
	function setSingleData(){
		chartData = [];
		for(var i = 0; i < tempData[0].length; i++){
			chartData.push({
				value0:tempData[0][i],
				value1:tempData[1][i]
			});
		}
		createSingleChart();		
	}
// ----------------------------------------
	function createSingleChart() {

	var chart = new AmCharts.AmStockChart();
	
			chart["export"] = {
			  "enabled": true
			};
		
		var categoryAxesSettings = new AmCharts.CategoryAxesSettings();
		categoryAxesSettings.minPeriod = "ss";
		chart.categoryAxesSettings = categoryAxesSettings;

		var valueAxesSettings = new AmCharts.ValueAxesSettings();
		valueAxesSettings.minimum = minYval;
		valueAxesSettings.maximum = maxYval;
		chart.valueAxesSettings = valueAxesSettings;


		var dataSet = new AmCharts.DataSet();

		dataSet.dataProvider = chartData;
		dataSet.categoryField = "value0";

		console.log(chartData);
				
		dataSet.fieldMappings = [
			{fromField: "value1", toField: "value1"}
		];
				
		chart.dataSets = [dataSet];
		
		var stockPanel1 = new AmCharts.StockPanel();
			stockPanel1.showCategoryAxis = true;
		//	stockPanel1.title = "Температура,°C";
			stockPanel1.percentHeight = 70;
				
		var graph = [];

		for(var i=1;i < tempData.length;i++){
			if(tempData[i].length != 0){
				graph[i] = new AmCharts.StockGraph();
			//	graph[i].title = "Температура,°C";
				graph[i].balloonText = "[[value]]°C";
				graph[i].useDataSetColors = false;
				graph[i].lineColor = "#FF0000";
				graph[i].valueField = "value" + parseInt(i);;
				graph[i].type = lineType[1]; // 0 - line, 1 - smoothedLine, 2 - column, 3 - step, 4 - candlestick, 5 - ohlc
				graph[i].lineThickness = 2;
				graph[i].bullet = "round";
				graph[i].bulletSize = 2;
				graph[i].bulletBorderColor = "white";
				graph[i].bulletBorderAlpha = 1;
				graph[i].bulletBorderThickness = 0;
				graph[i].id = parseInt(i);
				stockPanel1.addStockGraph(graph[i]);
			}
		}
	
		var stockLegend1 = new AmCharts.StockLegend();
			stockLegend1.valueTextRegular = " ";				
			stockPanel1.stockLegend = stockLegend1;	
				
			chart.panels = [stockPanel1];

		var scrollbarSettings = new AmCharts.ChartScrollbarSettings();
			scrollbarSettings.graph = graph[1];
			scrollbarSettings.usePeriod = "10mm";
			scrollbarSettings.updateOnReleaseOnly = false;
			scrollbarSettings.position = "bottom";
			
			chart.chartScrollbarSettings = scrollbarSettings;

		var cursorSettings = new AmCharts.ChartCursorSettings();
			cursorSettings.showNextAvailable = true;
			cursorSettings.cursorColor = "red";
			cursorSettings.valueLineEnabled = false;// true for value hor line
			cursorSettings.valueLineAlpha = 0.5;
			cursorSettings.categoryBalloonDateFormats = [
				{period:"YYYY", format:"YYYY"},
				{period:"MM", format:"MMM, YYYY"},
				{period:"WW", format:"DD MMM YYYY"},
				{period:"DD", format:"DD MMM YYYY"},
				{period:"hh", format:"DD MMM, JJ:NN:SS"},
				{period:"mm", format:"DD MMM, JJ:NN:SS"},
				{period:"ss", format:"DD MMM, JJ:NN:SS"},
				{period:"fff", format:"JJ:NN:SS"}]; // "fff"-milliseconds
			cursorSettings.valueBalloonsEnabled = true;
			cursorSettings.fullWidth = true;
			cursorSettings.cursorAlpha = 0.1;
			
			chart.chartCursorSettings = cursorSettings;

		var periodSelector = new AmCharts.PeriodSelector();
			periodSelector.position = "bottom";
			periodSelector.dateFormat = "YYYY-MM-DD JJ:NN";
			periodSelector.inputFieldWidth = 180;
			periodSelector.periods = [
				{
					period: "DD",
					selected: true,
					count: 3,
					label: "3 дні"
				}, {
					period: "DD",
					count: 5,
					label: "5 днів"
				}, {
					period: "MM",
					count: 1,
					label: "1 місяць"
				}, {
					period: "YYYY",
					count: 1,
					label: "1 рік"
				}, {
					period: "MAX",
					label: "MAX"
				}];
				chart.periodSelector = periodSelector;

		var panelsSettings = new AmCharts.PanelsSettings();
			panelsSettings.mouseWheelZoomEnabled = true;
				
			panelsSettings.usePrefixes = true;
			chart.panelsSettings = panelsSettings;
		chart.write('chartsingle');

	$("#chartsingle").fadeIn("slow");
}
// -----------------------------------
function setTempCol(){
	document.getElementById('tempred').value = t_red.toFixed(1);
	document.getElementById('tempblue').value = t_blue.toFixed(1);
	var t_mid = parseFloat(t_red + t_blue)/2.0;
	document.getElementById('midtemp').innerHTML = t_mid.toFixed(1);
	$('#ColorSet').modal("hide");
}
// -----------------------------------
function setColTemp(){
	t_red = parseFloat(document.getElementById('tempred').value);
	t_blue = parseFloat(document.getElementById('tempblue').value);
	var t_mid = parseFloat(t_red + t_blue)/2.0;
	document.getElementById('midtemp').innerHTML = t_mid.toFixed(1);
	initCol();
	$('#ColorSet').modal("hide");
}
// -----------------------------------
function showGrTrend(){
	$('#tempModal').modal("hide");
	$('#trendGrModal').modal("show");
	document.getElementById('grSilo').innerHTML = htitle;

	tempData = [];
		var val = hnum;
		if(val!=0){
			$.ajax({
				url:"getdata.php",
				type:"POST",
				data:({selhang:val}),
				dataType:"html",
				success:function(data){
					data = JSON.parse(data);
					for(var id in data){
						tempData[id] = [];
						for(var i in data[id]){
							tempData[id][i] = data[id][i];
						}
					}
				//	setTrendData();
					setTrendData(document.getElementById('chartGrdiv'));
				}
			});
		}
}