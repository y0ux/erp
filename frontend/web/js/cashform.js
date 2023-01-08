var form = $('#cash-form');
form.on('beforeSubmit', function (e) {
  console.log("before SubmitSubmit");
  if(confirm("Confirmo que los datos son correctos. Enviar?"))
    return true;
  return false;
});

window.onload = function() {
    $( ".cash-needs-total" ).each(function () {
        var input_value = $(this).val();
        console.log("input value: "+input_value);
        if (/^\d+$/.test(input_value)) {// .match(/^\d$/i) )
          updateNoteTotal($(this),input_value);
        }
    });
    $("#cashboxform-record_type input:radio:checked").each(function() {
        var radio_value = $(this).val();
        console.log("radio value: "+radio_value);
        updateCollapse (radio_value);
    });
}

$( ".cash-needs-total" )
  .change(function () {
      var input_value = $(this).val();
      console.log("input value: "+input_value);
      if (/^\d+$/.test(input_value)) {// .match(/^\d$/i) )
        updateNoteTotal($(this),input_value);
      }
      else {
        updateNoteTotal($(this), 0, true);
      }
  });
  //.change();

  $("#cashboxform-record_type input:radio").change(function() {
    var radio_value = $(this).val();
    console.log("radio value: "+radio_value );
    updateCollapse (radio_value);
  });

  function updateCollapse(radio_value) {
    if (radio_value == 10) {
      //if (!$("#form-cash-section").hasClass("collapse"))
        $("#form-income-section").removeClass("collapse.show").addClass("collapse");
      //if ($("#form-income-section").hasClass("collapse"))
        $("#form-cash-section").removeClass("collapse").addClass("collapse.show");
    }
    else if (radio_value == 20) {
      $(".collapse-section").each(function() {
        $(this).removeClass("collapse").addClass("collapse.show");
      });
    }
  }

  function updateNoteTotal(element, input_value, reset = false)
  {
      var name = element.attr("name");
      console.log (element);
      name = name.substring(
          name.indexOf("[") + 1,
          name.lastIndexOf("]")
      );
      var output = $( 'strong[name ="total-'+name+'"]' );
      if (reset) {
          output.text(0);
      }
      else {
          var multiplier = output.attr("data-value");
          var text_to_number = multiplier.search(/\./) < 0 ?
              parseInt(multiplier) * parseInt(input_value) :
              (parseFloat(multiplier) * input_value ).toFixed(2);
          output.text(text_to_number);
      }

      var totalQ = 0;
      console.log("totalQ: "+totalQ);
      $( ".currency-quetzal" ).each(function(){
        totalQ += parseFloat($(this).text());
        //console.log("totalQ: "+totalQ);
      });
      console.log("totalQ: "+totalQ);
      //$( '#total-cash-q' ).val(totalQ);
      //$( '#currency-total-q' ).text($( '#total-cash-q' ).attr("data-symbol")+totalQ);
      $( '#currency-total-q' ).text(totalQ);

      var totalD = 0;
      $( ".currency-usdollar" ).each(function(){
        console.log("totalD: "+totalD);
        totalD += parseFloat($(this).text());
      });
      $( '#total-cash-d' ).val(totalD);

      console.log($( '#total-cash-d' ));
      //$( '#currency-total-usdollar' ).text($( '#total-cash-d' ).attr("data-symbol")+totalD);
      $( '#currency-total-usdollar' ).text(totalD);

      var totalDQ = totalD * 7;//$( '#total-cash-dq' ).attr("data-exchangerate");
      $( '#total-cash-dq' ).val(totalDQ);
      //$( '#currency-total-dq' ).text($( '#total-cash-dq' ).attr("data-symbol")+totalDQ);
      $( '#currency-total-dq' ).text(totalDQ);

      var total = totalQ;// + totalDQ;

      total = parseFloat(total).toFixed(2);
      $( '#total-cashbox-q' ).val(total);
      $( '#total-cash' ).text(total);


      // CHECK WHEN OPENING VS CLOSING

      var initialCash = $( '#initial-cash' ).attr("data-value");
      var totalDifference = total - initialCash;
      $( "#difference-cash" ).text(totalDifference).parent().removeClass().addClass(function(){
        return totalDifference > 0 ? 'badge badge-success' : (totalDifference < 0? 'badge badge-danger' : 'badge badge-warning');
      });

      $('#cashboxform-cash_gtq').val(totalDifference > 0? totalDifference : 0);
      $('#cashboxform-cash_usd').val(totalD > 0? totalD : 0);

  }
