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
    {title:"Owner",field:"owner",headerFilter:true, headerFilterPlaceholder:"Filter by Owner..."},
    {title:"SCAC",field:"scac",headerFilter:true, headerFilterPlaceholder:"Filter by SCAC..."},
    {title:"Pro",field:"invoice_number",headerFilter:true, headerFilterPlaceholder:"Filter by PRO...",formatter:"link",formatterParams:{
      urlPrefix:"https://",     
      url:function (cell) {
        // using a temp variable to grap all the datapoints in the row as an object
        let rowDetails = cell.getRow(cell);
        // using the object from the above to return the scac and pro column values
        const scac = rowDetails.getData().scac;
        const pro = rowDetails.getData().invoice_number;
        // now that I have the oid I can build my url
        if (rowDetails.getData().inv_status == "Rejected") {
          return `payments.dblinc.net/php/lookup/getErrorID.php?scac=${scac}&pro=${pro}` 
        } else {
          return`payments.dblinc.net/php/lookup/noerror.php`
        }},
      target:"_blank"
      }},
    {title:"Total",field:"finv_charge",headerFilter:true, headerFilterPlaceholder:"Filter by Total...",formatter:"link",formatterParams:{
      urlPrefix:"https://",     
      url:function (cell) {
        // using a temp variable to grap all the datapoints in the row as an object
        let rowDetails = cell.getRow(cell);
        // using the object from the above to return the oid column value
        const oid = rowDetails.getData().oid;
        // now that I have the oid I can build my url
        return `abornandco.mercurygate.net/MercuryGate/settlement/viewInvoice.jsp?oidInvoice=${oid}&activeTab=details`},
        target:"_blank"
      }},
    {title:"Status",field: "inv_status",headerFilter:true, headerFilterPlaceholder:"Filter by Status...",formatter:function(cell){
      var value = cell.getValue();
       if(value == "Rejected"){
           return "<span style='color:red; font-weight:bold;'>" + value + "</span>";
       }else{
           return value;
       }
    }},
    {title:"Shipped", field:"ship_date",visible:false, download:true},
    {title:"Extracted", field:"extract_date",visible:false, download:true},
  ],
  initialSort:[
    {column:"primary_ref",dir:"desc"},
  ]
});

$("#export").click(function(){
table.download("csv", "extract.csv");
});
