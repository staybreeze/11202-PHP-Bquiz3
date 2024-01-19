<?php
include_once "db.php";
$movie=$Movie->find($_GET['movie_id']);
$date=$_GET['date'];
$session=$_GET['session'];
?>
<style>
 #room{
    background-image: url('./icon/03D04.png');
    background-position: center;
    background-repeat: none;
    width:540px;
    height:370px;
    margin:auto;
    box-sizing: border-box;
    padding:19px 112px 0 112px;
    
 }
 .seat {
    width: 63px;
    height: 85px;
    position: relative;
}

.seats {
    display: flex;
    flex-wrap: wrap;
}
.chk{
    position: absolute;
    right:2px;
    bottom:2px;
}
</style>

<div id="room">
<div class="seats">
    <?php
    for($i=0;$i<20;$i++){

        echo "<div class='seat'>";
        echo "<div class='ct'>";
        echo (floor($i/5)+1) . "排";
        echo (($i%5)+1) . "號";
        echo "</div>";
        echo "<div class='ct'>";
        echo "<img src='./icon/03D02.png'>";
        echo "</div>";
        echo "<input type='checkbox' name='chk' value='$i' class='chk'>";
        echo "</div>";
    }
    ?>
</div>

</div>
<div id="info">
<div>您選擇的電影是：<?=$movie['name'];?></div>
<div>您選擇的時刻是：<?=$date;?> <?=$session;?></div>
<div>您已經勾選<span id='tickets'>0</span>張票，最多可以購買四張票</div>
<div>
    <button onclick="$('#select').show();$('#booking').hide()">上一步</button>
    <button>訂購</button>
</div>
</div>

<script>
    // 創立一個新陣列放點選資料
let seats=new Array();

$(".chk").on("change",function(){
    if($(this).prop('checked')){
        if(seats.length+1<=4){
            // 如果不足四張的話，將資料push進seats裡
            seats.push($(this).val())
        }else{
            // 如果超過四張，把陣列裡該筆的勾選紀錄刪除
            $(this).prop('checked',false)
            alert("每個人只能勾選四張票")
        }
    }else{
        // splice 函數，目的是將陣列 seats 中特定值的元素移除
        // 具體而言，seats.indexOf($(this).val()) 用來找到陣列 seats 中第一次出現 $(this).val() 值的索引位置。
        // 接著，splice(index, 1) 會在陣列中的該索引位置刪除一個元素。
        // 這樣，seats 陣列中就移除了特定值。
        seats.splice(seats.indexOf($(this).val()),1)
    }
    console.log(seats.length)
    $("#tickets").text(seats.length)

})  

function checkout(){
    $.post("./api/checkout.php",{movie:'<?=$movie['name'];?>',
                                 date:'<?=$date;?>',
                                 session:'<?=$session;?>',
                                 seats},
                                 (no)=>{
                                    location.href=`?do=result&no=${no}`;
                                 })
}
</script>