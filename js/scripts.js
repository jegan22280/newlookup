// function navLink(cell, formatterParams) {
//   var load = cell.getValue();
//   return`<a href='https://payments.dblinc.net/php/payments/results.php?loads=${load}&SubmitButton=>${load}</a>`
// }

var table = new Tabulator("#ttable",{
  clipboard:true,
  height:"8000",
  ajaxURL:"_invoiceData.php",
  resizableColumns:false,
  layout:"fitColumns",
  groupStartOpen:false,
  groupToggleElement:"header",

  columns:[
    {title: "oid", field: "oid", visible:false},
    {title:"Load",field:"primary_ref",headerFilter:true, headerFilterPlaceholder:"Filter by Load...", formatter:"link",formatterParams:{
    urlPrefix:"https://",     
    url:function (cell) {
      var load = cell.getValue();
      return `payments.dblinc.net/php/payments/results.php?loads=${load}&SubmitButton=`
      },
    target:"_blank"
    }},
    {title:"Pro",field:"invoice_number",headerFilter:true, headerFilterPlaceholder:"Filter by PRO..."},
    {title:"Total",field:"finv_charge",headerFilter:true, headerFilterPlaceholder:"Filter by Total..."},
    {title:"Status",field: "inv_status",headerFilter:true, headerFilterPlaceholder:"Filter by Status...",formatter:function(cell){
      var value = cell.getValue();
       if(value == "Rejected"){
           return "<span style='color:red; font-weight:bold;'>" + value + "</span>";
       }else{
           return value;
       }
    }},
  ],
  initialSort:[
    {column:"primary_ref",dir:"desc"},
  ]
});

$("#export").click(function(){
table.download("csv", "extract.csv");
});
