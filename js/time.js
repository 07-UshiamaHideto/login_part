//日付データ
var a_date=new Date();
//日時を取得する
var year = a_date.getFullYear();
var month = a_date.getMonth()+1;
var week = a_date.getDay();
var day = a_date.getDate();

var hour = a_date.getHours();
var min = a_date.getMinutes();
var second = a_date.getSeconds();

var dates = 　""+year+month+day;
console.log("d:"+dates);
var week_m = new Array("日","月","火","水","木","金","土");

var times = ""+hour+min;
console.log("d:"+times);

//  $("#times").val(times);
//  $("#dates").val(dates);
document.getElementById("times").value = times;
document.getElementById("dates").value = dates;
