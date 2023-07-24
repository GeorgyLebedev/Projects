<?session_start();?>
<!DOCTYPE html>
<html lang="ru" >
<head>
<link rel="icon" href="/images/icon.png" type="image/png">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
<script src="xlsExport-master/xls-export.js"></script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="stylesheet" type="text/css" href="styles.css" />
<title>
Корелляционно-регрессионный анализ
</title>
</head>
<body bgcolor="#f5f5f5">
<h1>
Шаг 1. Загрузите данные для анализа.
</h1>
<form class=load method="post" enctype="multipart/form-data">
Файл для загрузки: <input id=file1 type="file" accept=".csv" name="filename" size="10" class=b1 /><br /><br/>
<input type=checkbox name=head value=withheader> С учетом заголовков 
<input type=checkbox name=del value=delete> Удалять некорректные строки <p>
<input id=loadbut type="submit" name="load" value="Загрузить" class=b1 />
<input  name="renew" type="submit"  value="Сбросить" class=b1 /><br><br> </p>
</form>
<script>
let btn = document.querySelector('#loadbut');
if (!document.getElementById('file1').value) btn.setAttribute('disabled', true);	
document.getElementById('file1').addEventListener('change', 
function(){
	let btn = document.querySelector('#loadbut');
	if (document.getElementById('file1').value){
		btn.removeAttribute("disabled");
	}
	else{
	btn.setAttribute('disabled', true);	}
});
</script>
<?php  
require_once __DIR__ . '/vendor/autoload.php';
use \Phpml\Regression\LeastSquares;
if (($_POST['load'] || $_POST['renew']) && ($_SESSION))
{
	$_SESSION=array();
}
if ($_SESSION){
	$cleararray=$_SESSION['array'];
	$string=$_SESSION['string'];
	$header=$_SESSION['header'];
	$cols=$_SESSION['cols'];
	showtable($cleararray,$string,false,$header,$cols,"t1");
	echo "<hr>";
} 
if ($_POST['load'] && $_FILES && $_FILES["filename"]["error"]== UPLOAD_ERR_OK && !$_POST['renew'])
{
	if($_POST['head']=='withheader') $header=true; else $header=false;
	if($_POST['del']=='delete') $delete=true; else $delete=false;
	$_SESSION=array(); unset($_POST['head']);unset($_POST['norma']);
	$name = $_FILES["filename"]["name"];
	$input=loadfile($name,$_FILES["filename"]["tmp_name"]);
	if (($csvData = file_get_contents($name)) !== FALSE){
	$lines = explode(PHP_EOL, $csvData);
	$input = array();
	$string=0; $cols=array();
	foreach ($lines as $line) {
		while (substr($line,-1)==",")
		$line = substr_replace($line ,"", -1);
		if ($line!==""){
		$input[] = str_getcsv($line);
		$string++;
		}
	}}
		if($delete)
		$cleararray=clear($input,$header);
		else $cleararray=$input;
	$cols=array();
	if ($header)
		$cols=$input[0];
	else
		for($j=0;$j<count($cleararray[0]);$j++){
			$h=($j+1);
			array_push($cols,"Столбец $h");
		}
	$_SESSION['array']=$cleararray;
	$_SESSION['string']=$string;
	$_SESSION['header']=$header;
	$_SESSION['cols']=$cols;
	showtable($cleararray,$string,false,$header,$cols,"t1");
	echo "<hr>";
}
if ($_FILES && !$_POST['renew'] && $_FILES["filename"]["error"]== UPLOAD_ERR_OK || ($_SESSION) ){?>
<h1>
Шаг 2. Нормализация значений.
</h1>
<form method="post" class=norm>
Выберите столбцы, значения которых нужно привести к диапазону [0;1]: <br>
<? $i=-1; 
$return=0;
foreach ($cols as $col){ 
	$i++;
	if(is_numeric($cleararray[1][$i])){?>
		<input type=checkbox class=colchoice name="chbx[]" value="<?=$col?>"><span><?=$col?></span><br>	<?}}?>
		<script>
	$(".colchoice").on("click", function() {
		if($(".colchoice:checked").length >= 2) { // Не больше 2-х checkbox		
			$(".colchoice:not(:checked)").attr("disabled", true);
			$(".colchoice:not(:checked)+span").css("color", 'gray');
		} else {	
		    $(".colchoice+span").css("color", 'black');
			$(".colchoice:disabled").attr("disabled", false);
		}
		if ($(".colchoice:checked").length == 2) $("#nbut").attr("disabled", false);	
		else $("#nbut").attr("disabled", true);	
	});	
</script>
<?
	echo "<br><input id=nbut type=submit name=norma disabled class=b1 value=Нормализация>";
	echo "<input type=hidden name=scroll value=></form>";
	if($_SESSION['normarray']){
		showtable($_SESSION['normarray'],$_SESSION['string'],true,$_SESSION['header'],$_SESSION['normalized'],"t2");
	} else{
	if ($_POST['norma']){ 
	$normcols=$_POST['chbx'];
	$_SESSION['normcols']=$normcols;
	$normalized=array();
	$normcolnumber=array();
	foreach($normcols as $ncol){
	$return=normalize($ncol,$cleararray, $header);
		if($return==0) break;
		array_push($normalized,$ncol);
		$j=0;
		if($header)
			while($cleararray[0][$j]!=$ncol){ $j++;}
		else{
			while($j!==((int)filter_var($ncol, FILTER_SANITIZE_NUMBER_INT)-1)){$j++;}}
		array_push($normcolnumber,$j);
		if($header){
		for($l=1;$l<sizeof($cleararray);$l++){
		$cleararray[$l][$j]=$return[$l-1];
		}}
		else{
		for($l=0;$l<sizeof($cleararray);$l++){
		$cleararray[$l][$j]=$return[$l];
		}}}
		$_SESSION['number']=$normcolnumber;
		if ($return!==0){
		$_SESSION['normarray']=$cleararray;
		$_SESSION['normalized']=$normalized;
		showtable($cleararray, $string,true, $header, $normalized,"t2");}
	}} 	
	}
if (($return!==0 && isset($return))||$_SESSION['normarray']){?>
<div style=text-align:center>
		<input type=image title="Сохранить таблицу в формате XLS" src="images/xls.png" class=b2 style="width:50px;display:inline;margin:0 auto;" onclick="savetable('norm' ,'xls')" >
		<input type=image title="Сохранить таблицу в формате TXT" src="images/txt.png" class=b2 style="width:50px;display:inline;margin:0 auto;" onclick="savetable('norm' ,'txt')" >
		<input type=image title="Сохранить таблицу в формате CSV" src="images/csv.png" class=b2 style="width:50px;display:inline;margin:0 auto;" onclick="savetable('norm' ,'csv')" >
		<input type=image title="Сохранить таблицу в формате PDF" src="images/pdf.png" class=b2 style="width:50px;display:inline;margin:0 auto;" onclick="savepdf('norm')" >
</div>
<hr><h1>
Шаг 3. Выявление зависимостей и построение графиков.
</h1>
<?
$cleararray=$_SESSION['normarray'];
$normcolnumber=$_SESSION['number'];
$header=$_SESSION['header'];
$LR=LinearRegression(array_column($cleararray,$normcolnumber[0]),array_column($cleararray,$normcolnumber[1]),$header);
if ($LR['r']<0 && $LR['r']>=-1) $otr=true; else $otr=false;
$contype=($otr)?'обратная':"прямая";
$coef=abs($LR['r']);
switch ($coef){
	case ($coef>0.7 && $coef<1): echo "Между признаками существует <u> сильная $contype связь</u>"; break;
	case ($coef>0.3 && $coef<0.7): echo "Между признаками существует <u> $contype связь средней силы</u>"; break;
	case ($coef>0.001 && $coef<0.3): echo "Между признаками существует <u> слабая $contype связь</u>"; break;
	case ($coef>=0 && $coef<0.001): echo "Связь между признаками <u>отсутствует</u>"; break;
}
echo "<br>Коэффициент корреляции равен: <b>".round($LR['r'],2)."</b><br>"; ?>
<p id=regtype> Вид регрессии: </p>
<?echo "<p id=equ></p>";
$X=($header)?array_slice(array_column($cleararray,$normcolnumber[0]),1):array_column($cleararray,$normcolnumber[0]);
$realY=($header)?array_slice(array_column($cleararray,$normcolnumber[1]),1):array_column($cleararray,$normcolnumber[1]);
sort($X);
sort($realY);
$_SESSION['Y']=$realY;
$_SESSION['X']=$X;
}
if(isset($LR) && $coef!=0){ ?>
<canvas id="chart" width="40%" height="20%">
</canvas>
<input type=image title="Скачать в формате PNG" src="images/png.png" class=b2 style="width:50px" onclick="saveCanvas('png')" >
<input type=image title="Скачать в формате JPG" src="images/jpg.png" class=b2 style="width:50px" onclick="saveCanvas('jpg')" >
<input type=image title="Скачать в формате PDF" src="images/pdf.png" class=b2 style="width:50px" onclick="saveCanvas('pdf')" >
<script>
function getImage(canvas){
    let imageData = canvas.toDataURL();
    let image = new Image();
    image.src = imageData;
    return image;
}
function saveImage(image, format) {
    let link = document.createElement("a");
    link.setAttribute("href", image.src);
    if (format=="png") link.setAttribute("download", "chart.png");
	if (format=="jpg") link.setAttribute("download", "chart.jpg");
    link.click();
}
function saveCanvas(format){
    let image = getImage(document.getElementById("chart"));
	if (format=="png") saveImage(image,"png");
	if (format=="jpg") saveImage(image,"jpg");
	if (format=="pdf"){ 
	canvas = document.getElementById('chart');
	image = {
    data: canvas.toDataURL('image/jpeg', 1),
    height: canvas.height,
    width: canvas.width};
  }
	createPDF(image);}
function createPDF(image) {
  let w = ConvertPxToMM(image.width);
  let h = ConvertPxToMM(image.height);
  let orientation = w > h ? 'l' : 'p';
  let docPDF = new jsPDF(orientation, 'mm', [w, h]);
  docPDF.addImage(image.data, 'JPEG', 0, 0);
  docPDF.output('save', 'chart.pdf');
}
function ConvertPxToMM(pixels) {
  return Math.floor(pixels * 0.264583);
}
function build(){
	let chartExist = Chart.getChart("chart"); 
    if (chartExist != undefined)  
		chartExist.destroy();
	let canvas = document.getElementById('chart');
	let context = canvas.getContext('2d');
		context.fillRect(0, 0, canvas.width, canvas.height);
	let regtype = document.getElementById('regtype');
	let slope=<?php echo json_encode($LR['slope']);?>;
	let intercept=<?php echo json_encode($LR['intercept']);?>;
	let a2=<?php echo json_encode($LR['a2']);?>;
	const labels = <?php echo json_encode($X);?>;
	let yreal=<?php echo json_encode($realY);?>;
	let contype=<?php echo json_encode($contype);?>
	/////??????contype??????/////////////////
	let diff= new Map();
	let y=[], y1=[], y2=[], y3=[], y4=[];
	let Ycalc=[];
	let delta=0;
	equation=document.getElementById('equ');
		for(let i=0;i<labels.length;i++){
			y.push(slope*labels[i]+intercept);
			delta+=Math.abs(y[i]-yreal[i]);
		} 		
		diff.set('linear',delta);
		delta=0;
		for(let i=0;i<labels.length;i++){
			y1.push(slope*labels[i]+intercept+a2*labels[i]*labels[i]);
			delta+=Math.abs(y1[i]-yreal[i]);
		} 
		diff.set('parabolic',delta);
		delta=0;
		for(let i=0;i<labels.length;i++){
			if(labels[i]!=0)
				y2.push(slope/labels[i]+intercept);
			else
				y2.push(slope/1e-5+intercept);
			delta+=Math.abs(y2[i]-yreal[i]);
		} 
		diff.set('hyperbolic',delta);
		delta=0;
		for(let i=0;i<labels.length;i++){
			if(!(slope<0 && labels[i]<1 && labels[i]>0)){
			y3.push(intercept*Math.pow(slope,labels[i]));
			delta+=Math.abs(y3[i]-yreal[i]);}
			else { delta=1e10; break;}
		} 
		diff.set('power',delta);
		delta=0;
		for(let i=0;i<labels.length;i++){
			if(labels[i]>0){
			y4.push(slope*Math.log(labels[i])+intercept);
			delta+=Math.abs(y4[i]-yreal[i]);} else { delta=1e10; break;}
		}
		diff.set('logarithmic',delta);
		delta=0;
		let min = diff.get('power');
		let index = 'power';
		diff.forEach((value, key) => {
		if (value<min) {
			min=value;
			index=key;}});
		switch (index){
		case "linear":
		equation.innerHTML=`Уравнение регрессии: <b>Y=${slope.toFixed(4)}*X+${intercept.toFixed(4)}</b>`;
		regtype.innerHTML+=" <b>Линейная</b>";
		Ycalc=Array.from(y);
		break;
		case "parabolic":
		equation.innerHTML=`Уравнение регрессии: <b>Y=${intercept.toFixed(4)}+${slope.toFixed(4)}*X+${a2.toFixed(4)}*X<sup>2</sup></b>`;
		regtype.innerHTML+=" <b>Параболическая</b>";
		Ycalc=Array.from(y1);
		break;
		case "hyperbolic":
		equation.innerHTML=`Уравнение регрессии: <b>Y=${slope.toFixed(4)}/X+${intercept.toFixed(4)}</b>`;
		regtype.innerHTML+=" <b>Гиперболическая</b>";
		Ycalc=Array.from(y2);
		break;
		case "power":
		equation.innerHTML=`Уравнение регрессии: <b>Y=${intercept.toFixed(4)}*${slope.toFixed(4)}<sup>X</sup></b>`;
		regtype.innerHTML+=" <b>Показательная</b>";
		Ycalc=Array.from(y3);
		break;
		case "logarithmic":
		equation.innerHTML=`Уравнение регрессии: <b>Y=${slope.toFixed(4)}*ln(X)+${intercept.toFixed(4)}</b>`;
		regtype.innerHTML+=" <b>Логарифмическая</b>";
		Ycalc=Array.from(y4);
		break;
		}
	let dataset = {
	labels: labels,
	datasets: [{
	  label: 'График регрессии',
	  backgroundColor: 'Teal',
	  borderColor: 'Teal',
	  radius:0,
	  data: Ycalc
	},{
		  label: 'Реальные значения',
		  type: "scatter",
		  pointStyle:"rect",
		  radius: 4,
		  backgroundColor: "DarkOrange",
		  data: yreal
		}]
	};
const plugin = {
  id: 'custom_canvas_background_color',
  beforeDraw: (chart) => {
    const ctx = chart.canvas.getContext('2d');
    ctx.save();
    ctx.globalCompositeOperation = 'destination-over';
    ctx.fillStyle = 'White';
    ctx.fillRect(0, 0, chart.width, chart.height);
    ctx.restore();
  }
};
	let config = {
	type: 'line',
	data: dataset,
	plugins: [plugin],
	options: {
		scales: {
        x: {	
			grid: {
				color:'Gray'
			},
            ticks: {
				color: "Black",
                font: {
					family: 'Cambria Math',
                    size: 13.5,
					}
				}
			},
		y: {
			grid: {
				color:'Gray'
			},
            ticks: {
				color: "Black",
                font: {
					family: 'Cambria Math',
                    size: 14,
					}
				}
			}
		},
		plugins: {
            legend: {
                labels: {
					color: "Black",
                    font: {
						family: 'Cambria Math',
                        size: 15
                    }
                }
            }
        }
	}
	};

	let myChart = new Chart(
	context, 
	config
	);
	}
</script>
<script>
build();
</script>
<hr>
<h1> Шаг 4. Составление прогнозов. </h1>
<div class="tabs">
<? 
$normcols=$_SESSION['normcols'];
$normcols[0]=(str_replace(' ','',$normcols[0]));
$normcols[1]=(str_replace(' ','',$normcols[1])); 
if ($_POST['load2']||$_POST['pred2']){
	$_SESSION['tabbtn']="formany";
}	
if ($_POST['pred1']){
		$_SESSION['tabbtn']="forone";
		if ($_POST['subject']==$normcols[0]){
			$checked1='checked';
			$checked2='';
		}
		else{
			$checked2='checked';
			$checked1='';
		}		
}
else {
	$checked1='checked';
	$checked2='';	
}
	?>
<input type="radio" name="tabbtn" id="tab-btn-1" value="forone" <?php if ($_SESSION['tabbtn']=="forone" || !isset($_SESSION['tabbtn'])) echo "checked"; ?> >
<label for="tab-btn-1">Для одного студента</label>
<input type="radio" name="tabbtn" id="tab-btn-2" value="formany"  <?php if ($_SESSION['tabbtn']=="formany")  echo "checked"; ?>>
<label for="tab-btn-2">Для списка студентов</label>
<div id="content-1">
	<form method=post>
	Выберите дисциплину, для которой нужно получить прогноз:<br>
	<? 
		echo "<input class=subject1 type=radio value=$normcols[0] name=subject $checked1><q>$normcols[0]</q><br>";
		echo "<input class=subject2 type=radio value=$normcols[1] name=subject $checked2><q>$normcols[1]</q><br>";
		echo "<br>";
	?>
	Введите оценку по предмету <q id=subj1><? echo $normcols[1]?></q>: <br>
	<input type=number name=ocenka  style=width:75px; maxlength=4 id=field step=0.1 min=0.0 max=5.0 class=b1> </input>
	<input type=submit name=pred1 id=pred value=Прогноз class=b1 disabled></input>
	<input type=hidden name=scroll value=></input>
	</form>
		<? 
		if ($_POST['pred1']){
		$regression=train($_SESSION['X'],$_SESSION['Y'],$_POST['subject'],$normcols);
		$mark=$_POST['ocenka'];
		$arr=$_SESSION['array'];
		if ($header)
		unset($arr[0]);
		$num=($_POST['subject']==$normcols[0])?0:1;
		$min=min(array_column($arr,$normcolnumber[$num]));
		$max=max(array_column($arr,$normcolnumber[$num]));
		$mark=($mark-$min)/($max-$min);
		$predict=(round($regression->predict([$mark]),2)*5);
		$color="";
		if ($predict<0) $predict=0;
		if ($predict>5) $predict=5;
		if ($predict>3.5) $color="green"; 
		if ($predict<=3.5 && $predict>2.5) $color="orange";
		if ($predict<=2.5) $color="red"; 
		echo "<p>Прогнозируемая оценка по предмету <q id=subj2>$normcols[0]</q>:<br>
		<input id=out1 class=b1 style=color:$color;font-weight:600;width:75px;text-align:center; type=text readonly value=$predict>
		</input><input type=image title='Скопировать в буфер обмена' src=images/copy.png  style=width:25px; onclick=Copytext() ><span id=out2></span></p>";
		}
		?>
		<script> 
			function Copytext(){
				text=document.querySelector('#out1');
				par=document.querySelector('#out2');
				text.select();
				document.execCommand("copy");
				par.innerHTML="";
				par.innerHTML+="<br>Скопировано!";
			}
			const button1=document.querySelector('.subject1')
			button1.addEventListener('change',function(){
				subject1=document.getElementById("subj1");
				subject1.innerHTML='';
				subject1.innerHTML+=$('input[name="subject"]:not(:checked)').val();
				subject2=document.getElementById("subj2");
				subject2.innerHTML='';
				subject2.innerHTML+=$('input[name="subject"]:checked').val();
			});
			const button2=document.querySelector('.subject2')
			button2.addEventListener('change',function(){
				subject1=document.getElementById("subj1");
				subject1.innerHTML='';
				subject1.innerHTML+=$('input[name="subject"]:not(:checked)').val();
				subject2=document.getElementById("subj2");
				subject2.innerHTML='';
				subject2.innerHTML+=$('input[name="subject"]:checked').val();
			});
			$('body').on('input', 'input[type="number"][maxlength]', function(){
			if (this.value.length > this.maxLength){
				this.value = this.value.slice(0, this.maxLength);
			}
			});
			$('body').on('input', '.input-number', function(){
			this.value = this.value.replace(/[^0-9\.\,]/g, '');
			});
			document.getElementById('field').addEventListener('change', 
			function(){
			let btn2 = document.querySelector('#pred');
			if (document.getElementById('field').value) btn2.removeAttribute("disabled");
			else btn2.setAttribute('disabled', true);
			});
		</script>
	</div>
	<div id="content-2">
		<form class=load method="post" enctype="multipart/form-data">
		Файл для загрузки: <input id=file2 type="file" name="filename" accept=".csv" size="10" class=b1 /><br /><br/>
		<input type=checkbox name=head2 value=withheader> С учетом заголовков 
		<input type=checkbox name=del2 value=delete> Удалять некорректные строки <p>
		<input id=loadbut2 type="submit" name="load2"  value="Загрузить" class=b1 /><br><br> </p>
		<input type=hidden name=scroll value=></input>
		</form>
		<? if ($_POST['load2'] && $_FILES && $_FILES["filename"]["error"]== UPLOAD_ERR_OK && !$_POST['renew']){
			if($_POST['head2']=='withheader') $header2=true; else $header2=false;
			if($_POST['del2']=='delete') $delete2=true; else $delete2=false;
			$name = $_FILES["filename"]["name"];
			loadfile($name,$_FILES["filename"]["tmp_name"]);
			if (($csvData = file_get_contents($name)) !== FALSE){
				$lines = explode(PHP_EOL, $csvData);
				$input2 = array();
				$string2=0; $cols2=array();
				foreach ($lines as $line) {
					while (substr($line,-1)==","){
					$line = substr_replace($line ,"", -1);
					} 
					if ($line!==""){
					$input2[] = str_getcsv($line);
					$string2++;
					}
				}
				if($delete2)
				$cleararray2=clear($input2, $header2);
				else $cleararray2=$input2;
				$cols2=array();
				if ($header2)
					$cols2=$input2[0];
				else
					for($j=0;$j<count($cleararray2[0]);$j++){
						$h=($j+1);
						array_push($cols2,"Столбец $h");
					}
				showtable($cleararray2,$string2,false,$header2,$cols2,"t3");
				$_SESSION['array2']=$cleararray2;
				$_SESSION['header2']=$header2;
				$_SESSION['cols2']=$cols2;
				$_SESSION['string2']=$string2;
				$i=-1;
				echo "<form method=post>";
				echo "<input type=hidden name=scroll value=></input>";
				echo "Выберите столбец, по значениям которого будет составляться прогноз:<br>";
				$check='checked'; 
				foreach ($cols2 as $col2){ 
					$i++;
				if(is_numeric($cleararray2[1][$i])){
				echo "<input type=radio class=colchoice name='rad[]' $check value='$col2'><span>$col2</span><br>";$check='';}}
				echo "Выберите дисциплину, для которой нужно получить прогноз:<br>";
			echo "<input class=subject1 type=radio value=$normcols[0] name=subject $checked1><q>$normcols[0]</q><br>";
			echo "<input class=subject2 type=radio value=$normcols[1] name=subject $checked2><q>$normcols[1]</q><br>";
			echo "<br>";
				echo "<input class=b1 name=pred2 type=submit value=Прогноз /></form>";
				}	
			}
				if($_POST['pred2']){
					$cols2=$_SESSION['cols2'];
					$string2=$_SESSION['string2'];
					$cleararray2=normalize(implode($_POST['rad']),$_SESSION['array2'], $_SESSION['header2']);
					$regression=train($_SESSION['X'],$_SESSION['Y'],$_POST['subject'],$normcols);
					$predicted=array();
					foreach($cleararray2 as $car2)
					{
						$predict=(round($regression->predict([$car2]),2)*5);
						if($predict<0)$predict=0;
						if($predict>5)$predict=5;
						array_push($predicted,$predict);
					}
					if ($_SESSION['header2']) array_unshift($predicted,"");
					$final = array();
					$iter=0;
					foreach($_SESSION['array2'] as $arr2) {
						$final[] = array_merge($arr2,array($predicted[$iter]));
						$iter++;
					}
					array_push($cols2,"Прогнозируемое значение по ".$_POST[subject].".");
					if (!$_SESSION['header2']) array_unshift($final,$cols2);
					else{
						$final[0]=$cols2;
					}
					if(showtable($final,$string2,false,true,$cols2,"t4")!==false){?>
				<div style=text-align:center>
				<input type=image title="Сохранить таблицу в формате XLS" src="images/xls.png" class=b2 style="width:50px;display:inline;margin:0 auto;" onclick="savetable('final' ,'xls')" >
				<input type=image title="Сохранить таблицу в формате TXT" src="images/txt.png" class=b2 style="width:50px;display:inline;margin:0 auto;" onclick="savetable('final' ,'txt')" >
				<input type=image title="Сохранить таблицу в формате CSV" src="images/csv.png" class=b2 style="width:50px;display:inline;margin:0 auto;" onclick="savetable('final' ,'csv')" >
				<input type=image title="Сохранить таблицу в формате PDF" src="images/pdf.png" class=b2 style="width:50px;display:inline;margin:0 auto;" onclick="savepdf('final')" >
				</div>
					<?	}}?>
		<script>
		let btn2 = document.querySelector('#loadbut2');
		if (!document.getElementById('file2').value) btn2.setAttribute('disabled', true);	
		document.getElementById('file2').addEventListener('change', 
		function(){
			let btn2 = document.querySelector('#loadbut2');
			if (document.getElementById('file2').value) btn2.removeAttribute("disabled");
			else btn2.setAttribute('disabled', true);	
		});
		</script>
	</div>
</div>
<?}?>
<script>
$(window).on("scroll", function(){
	$('input[name="scroll"]').val($(window).scrollTop());
});
 
<?php if (!empty($_REQUEST['scroll'])): ?>
$(document).ready(function(){
	window.scrollTo(0, <?php echo intval($_REQUEST['scroll']); ?>);  
}); 
<?php endif; ?>
</script>
</body>
</html>
<script>
function savepdf(source){
let array;
array=(source=='norm')? <?php echo json_encode($cleararray);?>:<?php echo json_encode($final);?> ;
 let win = window.open('', '', 'height=800,width=600');
  win.document.write('<html><head>');
let style = "<style>";
style = style + "table {width: 100%;font-family:'Cambria Math'}";
style = style + "table, th, td {border: solid 1px #DDD; border-collapse: collapse;";
style = style + "padding: 2px 3px;text-align: center;}";
style = style + "</style>";    
 win.document.write(style);
        win.document.write('</head>');
        win.document.write('<body><table>');
		for(i=0;i<array.length;i++){
				win.document.write("<t>");  
			for(j=0;j<array[i].length;j++){
		win.document.write("<td>");  
        win.document.write(`${array[i][j]}`);  
		win.document.write("</td>");  
		if((j+1)==array[i].length) win.document.write("</tr>");  
		}}				
        win.document.write('</table></body></html>');
		win.document.close();
 win.print();
 }
function savetable(source,format){
	if(format=="csv" || format=="xls"){
		let data;
		if(format=="xls"){
		data =(source=='norm')? <?php echo json_encode($cleararray);?>:<?php echo json_encode($final);?> ;
		const xls = new XlsExport(data);
		xls.exportToXLS('table.xls');
		}
		if(format=="csv"){
		data =(source=='norm')? <?php echo json_encode($cleararray,JSON_UNESCAPED_UNICODE);?>:<?php echo json_encode($final,JSON_UNESCAPED_UNICODE);?> ;
		const xls = new XlsExport(data);
		xls.exportToCSV('table.csv')
		}
	}
	if(format=="txt"){
		let text =(source=='norm')? <?php echo json_encode($cleararray);?>:<?php echo json_encode($final);?> ;
		let out="";
		for(i=0;i<text.length;i++){
			out+=text[i];
			out+='\r\n';
		}
    let myData = 'data:application/txt;charset=utf-8,' + encodeURIComponent(out);
	let link = document.createElement("a");
    link.href=myData;
    link.download='table.txt';
	link.click();
	}
}
</script>
<? 
function normalize(string $col,array $arr, bool $header){
	$j=0;
	$normalized=array();
	if ($header){
	while($arr[0][$j]!=$col){
		$j++;
	}}
	else{
	while($j!==((int)filter_var($col, FILTER_SANITIZE_NUMBER_INT)-1)){
		$j++;
	}}
	$samples=array_column($arr,$j);
	if ($header) unset($samples[0]);
	$max=max($samples); $min=min($samples); 
	if ($max==$min) {
		echo "<p class=err>Невозможно провести нормализацию для столбца ".$col.", так как он включает только одно значение!</p>";
		return 0;
	}
	$k=0;
	foreach($samples as $s){
		$k++;
		if(!is_numeric($s) || is_null($s)){
		echo "<p class=err>Значение <b><u>".$s."</u></b> не является числом! (Строка: $k, Столбец: $col)</p>";
		return 0;
		}}
	foreach($samples as $s) {array_push($normalized,round((($s-$min)/($max-$min)),5));} 
	return $normalized;
}
function showtable(array $input, int $count, bool $color, bool $header, array $columns, string $id){
	echo "<table id=$id class=data>"; 
	$altcols=array();
	if(!$header){
	foreach ($columns as $col){
		array_push($altcols,((int)filter_var($col, FILTER_SANITIZE_NUMBER_INT)));
	}}
	$first=($header==true)?true:false; 
	$i=($header==true)?0:1;  $alt=false;
	if ($count>50) $alt=true;
	$topaint=array();
	foreach($input as $row => $c)
	{
		if (($alt &&($count-$i)>20 && $i>20)) {$i++;continue;}
		echo "<tr>";
		if (!$first)
		echo "<td class=num> $i </td>";	
		else echo "<th class=num> </th>";	
		$iter=0;
		foreach($c  as  $col => $value)
		{
			if ($color)
			if (in_array($value,$columns) || (!$header && in_array(($iter+1),$altcols))) array_push($topaint,$iter);
			if($header){
			if ($first && !in_array($iter,$topaint)) echo "<th> $value </th>";
			elseif ($first && in_array($iter,$topaint)) echo "<th style=color:Teal> $value </th>";}
			if (!$first && !in_array($iter,$topaint)) echo "<td> $value </td>";	
			if (!$first && in_array($iter,$topaint)) echo "<td style=color:Teal> $value </td>";
			$iter++;
		}
	$i++;
	echo "</tr>";
	if ($i==21){
		echo "<tr><td class=num>...</td></tr>";
	}
	$first=false;
	}
	echo "</table>";
}		
function LinearRegression(array $y, array $x, bool $header){
	$lr = array();
	$n = count($y);
	$sum_x = 0;
	$sum_y = 0;
	$sum_xy = 0;
	$sum_xx = 0;
	$sum_yy = 0;
	$i=($header)?1:0;
	for ($i; $i < count($y); $i++) {
		$sum_x += $x[$i];
		$sum_y += $y[$i];
		$sum_xy += ($x[$i]*$y[$i]);
		$sum_xx += ($x[$i]*$x[$i]);
		$sum_yy += ($y[$i]*$y[$i]);
	} 

	$lr['slope'] = ($n * $sum_xy - $sum_x * $sum_y) / ($n*$sum_xx - $sum_x * $sum_x);
	$lr['intercept'] = ($sum_y - $lr['slope'] * $sum_x)/$n;
	$lr['r'] = ($n*$sum_xy - $sum_x*$sum_y)/sqrt(($n*$sum_xx-$sum_x*$sum_x)*($n*$sum_yy-$sum_y*$sum_y));
	$lr['a2']=($sum_y-$n*$lr['intercept']-$sum_x*$lr['slope'])/$sum_xx;
	return $lr;
}
function clear(array $array, bool $withheader){
	$total=0;
	for ($t=0; $t<count($array[0]);$t++){
		$stroki=0;
		$chisla=0;
		$erase=false;
		for ($r=0; $r<(count($array)+1);$r++){
			if(!is_numeric($array[$r][$t]) && isset($array[$r][$t])){
			$stroki++;} else $chisla++;
		}
		if ($chisla>$stroki) $erase=true;
		for ($r=0; $r<(count($array)+1);$r++){
			if(!is_numeric($array[$r][$t]) && isset($array[$r][$t])&& $erase && !($withheader && $r==0)){
				unset($array[$r]); $total++;
			}}			
	}
	echo "Удалено некорректных строк: $total";
	$cleararray=array();
	foreach($array as $arr)
	if($arr) array_push($cleararray,$arr);
	return $cleararray;
}
function loadfile(string $filename, string $tempname){
	$fileNameCmps = explode(".", $filename);
	$fileExtension = strtolower(end($fileNameCmps));
	if ($fileExtension != "csv"){
		echo "<p class=err>Ошибка! Загружаемый файл не является файлом формата CSV!</p>";
		exit(1);
	}
	move_uploaded_file($tempname, $filename);
	$file = fopen($filename, 'r');
	$text = fread($file, filesize($filename));
	fclose($file);
	if(substr_count($text, ';')>0){
		$text = str_replace(';', ',', $text);
		$file = fopen($filename, 'w');
		if (fwrite($file, $text)!==false){
			fclose($file);
		}
		else{
			echo "<p class=err>Ошибка! Файл не может быть загружен из-за повреждения или некорректной записи!</p>";
			exit(1);
		}
	}
}
function train(array $x, array $y, string $chosenval, array $cols){
	$regression = new LeastSquares();
	$arrtotrain=array(array(),array());
	if($chosenval==$cols[0]){
	for ($j=0;$j<count($x);$j++)
	$arrtotrain[$j][0]=$x[$j];
	$regression->train($arrtotrain, $y); }
	if($_POST['subject']==$cols[1]){
	for ($j=0;$j<count($y);$j++)
	$arrtotrain[$j][0]=$y[$j];
	$regression->train($arrtotrain, $x);	}
	return $regression;
}