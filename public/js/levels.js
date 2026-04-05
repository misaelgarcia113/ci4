let tableLevels;

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
                            <button class="btn btn-danger btn-delete btn-sm" 
                                    data-pk_level="${row.pk_level}" 
                                    title="Elimina nivel ${row.pk_level}">
                                <i class="fa fa-trash"></i>
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

function actionTable() 
{
    $('#myTableLevels tbody').on('click', '.btn-delete', function () 
    {
        const row = $(this).closest('tr');
        const pk_level = $(this).data('pk_level');
        
        const level = [pk_level];
        
        deleteLevel(level);
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

function deleteLevel(level)
{
    var url = "http://localhost/ci4/admin/apiDelete";

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