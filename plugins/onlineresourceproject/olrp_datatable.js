/* Uses JQuery DataTables to add interactivity to all tables of class olrp_display_table */

  jQuery(document).ready(function(){
    jQuery(".olrp_display_table").DataTable({
      dom: 'Bfrtip',
      buttons: {
        buttons: [
          { extend: 'copy', className: 'olrp_button' },
          { extend: 'excel', className: 'olrp_button' },
          { extend: 'csv', className: 'olrp_button' },
          { extend: 'print', className: 'olrp_button' }
        ]
      },
        "columnDefs": [
          {
            "targets": [ 1 ],
            "visible": false,
            "searchable": false
          }
        ],
      initComplete: function() {
        /* Fix the text color of the buttons, DataTables isn't playing nice with Wordpress theme*/
        jQuery('.dt-button').css("color","black");
        /*
         jQuery('.dt-button').removeClass('dt-button'); //makes ugly buttons, loses rollover
        */

      },
      }
    );
  });

