let tableLevels; // Global

$(document).ready(function () 
{
    myTable();
    buttonLevel();
});

function myTable() 
{
    var url = "http://localhost/ci4/admin/read";

    if (!$.fn.DataTable.isDataTable('#myTableLevels')) 
    {
        tableLevels = new DataTable('#myTableLevels', 
        {
            ajax: 
            {
                url: url,
                type: 'GET',
                dataSrc: 'levels'
            },

            responsive: true,
            scrollCollapse: true,
            scrollX: true,
            scrollY: true,
            autoWidth: false,
            deferRender: true,

            columns: 
            [
                { title: "pk_level", data: "pk_level", width: "20%", className: "text-center" },
                { title: "level",    data: "level",    width: "60%" },
                { title: "action",   data: null,       width: "20%", className: "text-center" }
            ],

            columnDefs: 
            [
                {
                    targets: 2,
                    orderable: false,
                    className: "text-center",
                    render: function (data, type, row) 
                    {
                        return `
                            <button class="btn btn-primary btn-ver btn-sm" 
                                    data-pk_level="${row.pk_level}" 
                                    title="Ver nivel ${row.pk_level}">
                                <i class="fa fa-eye"></i> Ver
                            </button>`;
                    }
                }
            ],

            aLengthMenu: 
            [
                [3, 5, -1], [3, 5, "Todos"]
            ],

            language: 
            {
                url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
            }
        });

        actionTable();
    } 
    else 
    {
        tableLevels.ajax.reload();
    }
}

/*function myTable() 
{
    var url = "http://localhost/ci4/admin/read";

    $.ajax({
        type: 'GET',
        url: url,
        dataType: 'json',

        success: function (response) 
        {
            window.levels = response.levels;

            if (!$.fn.DataTable.isDataTable('#myTableLevels'))
            {
                tableLevels = new DataTable('#myTableLevels', {
                    data: window.levels,
                    responsive: true,
                    scrollCollapse: true,
                    scrollX: true,
                    scrollY: true,
                    autoWidth: false,
                    deferRender: true,
                    
                    columns:
                    [
                        { title: "pk_level", data: "pk_level", width: "20%", className: "text-center" },
                        { title: "level",    data: "level",    width: "60%" },
                        { title: "action",   data: null,       width: "20%" }
                    ],

                    columnDefs: 
                    [
                        {
                            targets: 2,
                            orderable: false,
                            className: "text-center",
                            render: function (data, type, row) {
                             return `
                                <button class="btn btn-primary btn-ver btn-sm" data-pk_level="${row.pk_level}" title="Ver nivel ${row.pk_level}">
                                    <i class="fa fa-eye"></i> Ver
                                </button>`;
                            }
                        }
                    ],

                    aLengthMenu: [
                        [3, 5, -1], [3, 5, "All"]
                    ],

                    language: 
                    {
                        url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
                    }
                });

                actionTable(); 
            } 
            else 
            {
                // Si ya existe, solo actualizamos los datos
                tableLevels.clear().rows.add(window.levels).draw();
            }
        },

        error: function (xhr, status, error) 
        {
            console.error("Error en la solicitud AJAX:", status, error);
        }
    });
}*/

function actionTable() 
{
    $('#myTableLevels tbody').on('click', '.btn-ver', function () 
    {
        const row = $(this).closest('tr');
        const pk_level = $(this).data('pk_level');
        
        const infoLevel = [pk_level];
        
        alert(infoLevel);
        //edit(infoCustomer);
    });
}

function edit(infoCustomer)
{
    alert('Info'+infoCustomer);
    var url = "https://villafuerte.site/villanet/customer/edit";
    
    $.ajax({
        type: 'POST',
        url: url,
        data: {'infoCustomer': infoCustomer },

        success: function (response) 
        {

        },

        error: function (xhr, status, error) 
        {
            console.error("Error en la solicitud AJAX:", status, error);
        }
    });
}

function buttonLevel()
{
    $('#btnLevel').click(function()
    {
        var level = $('#level').val();
        
        if(level.length != 0)
        {
            createLevel(level);
        }
    });
}

function createLevel(level)
{
    var url = "http://localhost/ci4/admin/apiCreate";

    $.ajax({
        type: 'POST',
        url: url,
        data: {'level': level},

        success: function (response) 
        {
            if(response.status == 200)
            {
                Swal.fire
                ({
                    title: response.message,
                    icon:  response.icon,
                    timer: 1500,
                    showConfirmButton: false
                });

                tableLevels.ajax.reload();
            }
        },

        error: function (xhr, status, error) 
        {
            console.error("Error en la solicitud AJAX:", status, error);
        }
    });
}
