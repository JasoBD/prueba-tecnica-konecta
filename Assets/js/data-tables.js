(function ($) {
  $.fn.extend({
    dataTable: function (options) {
      try {
        this.geData(options);
      } catch (error) {
        console.log(error);
      }
    },
    geData(options) {
      const { columns, ajax, action } = options;
      $.ajax({
        // la URL para la petición
        url: ajax,
        // la información a enviar
        // (también es posible utilizar una cadena de datos)
        // especifica si será una petición POST o GET
        type: "GET",
        // el tipo de información que se espera de respuesta
        dataType: "json",

        // código a ejecutar si la petición es satisfactoria;
        // la respuesta es pasada como argumento a la función
        success: (json) => {
          this.loaData(columns, action, json);
        },
        error: (xhr, status) => {},
        // código a ejecutar sin importar si la petición falló o no
        complete: function (xhr, status) {},
      });
    },
    loaData(columns, action, data) {
      let table = `<table class="table table-striped"<thead><tr><th scope="col">#</th>`;
      for (const column of columns) {
        table += `<th scope="col">${
          column.data.charAt(0).toUpperCase() + column.data.slice(1)
        }</th>`;
      }
      if (action) {
        table += `<th scope="col"> Actions</th>`;
      }
      table += `</tr></thead>`;
      table += `<tbody>`;
      for (let index = 0; index < data.length; index++) {
        let rows = data[index];
        table += `<tr>`;
        table += `<th scope="row">${index + 1}</th>`;
        for (const column of columns) {
          table += `<td>${rows[column.data]}</td>`;
        }
        if (action) {
          table += `<td>${action(rows)}</td>`;
        }
        table += `</tr>`;
      }
      table += `</tbody></table>`;
      $(this).html(table);
    },
  });
})(jQuery);
