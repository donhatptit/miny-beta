
$(document).ready(function(){
    // tooltip
    $('[data-toggle="tooltip"]').tooltip();
    $('.calculate').click(function(){
        $('.equation-detail table').toggleClass('padding-detail');
        $('.cal').toggleClass('show_calculator');
    });
    count_td = $('#g_mol td').length;
    count = count_td - 2;
    $( "#mol input" ).keyup(function() {
        var mol_boss = $(this).val();
        var pos = ($(this).parent().index());
        var factor_boss = $("#factor td:eq("+pos+") input").val();
        for (i = 0; i< count; i++){
            if ( i%2 != 1 ) {
                var factor = $("#factor td:eq("+i+") input").val();
                var g_mol = $("#g_mol td:eq("+i+") input").val();
                if (i != pos){
                    var mol = Math.round(mol_boss/factor_boss*Number(factor) * 1000) / 1000 ;
                }else{
                    var mol = mol_boss;
                }
                $("#mol td:eq("+i+") input").val(mol);
                $("#g td:eq("+i+") input").val(Math.round(mol*Number(g_mol) * 1000) / 1000);
            }
        }

    });
    $( "#g input" ).keyup(function() {
        var g = $(this).val();
        var pos = ($(this).parent().index());
        var mol_boss = Math.round(g/Number($("#g_mol td:eq("+pos+") input").val()) * 1000) / 1000 ;
        var factor_boss = $("#factor td:eq("+pos+") input").val();
        for (i = 0; i< count; i++){
            if ( i%2 != 1 ) {
                var factor = $("#factor td:eq("+i+") input").val();
                var g_mol = $("#g_mol td:eq("+i+") input").val();
                if (i != pos){
                    var mol = Math.round(mol_boss/factor_boss*Number(factor) * 1000) / 1000 ;
                    $("#g td:eq("+i+") input").val(Math.round(mol*Number(g_mol) * 1000) / 1000);
                }else{
                    var mol = mol_boss;
                }
                $("#mol td:eq("+i+") input").val(mol);

            }
        }
    });

});






