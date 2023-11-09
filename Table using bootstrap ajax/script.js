$(document).ready(function () {
    var participantsArray = [];
  
    document.getElementById("participants").addEventListener("keypress", function(event) {
        if (event.key === "Enter") {
          document.getElementById("addButton").click();
          event.preventDefault();
        }
      });

    $("#addButton").click(function () {
        var participantsInput = $("#participants").val().trim();
        if (participantsInput === "") {
            showError("Поле \"Участники\" не может быть пустым.");
            return;
        }
  
        // Проверяем, что введены только кириллические буквы и запятая
        var regex = /^[а-яА-ЯёЁ, ]+$/;
        if (!regex.test(participantsInput)) {
            showError("Допустимы только кириллические буквы и запятая.");
            return;
        }
  
        var participantsNames = participantsInput.split(",");
        for (var i = 0; i < participantsNames.length; i++) {
            var name = participantsNames[i].trim();
            if (name !== "") {
                participantsArray.push({
                    id: participantsArray.length + 1,
                    name: name,
                    score: 0
                });

                // Делаем ajax-запрос на сервер для генерации очков
                $.ajax ({ 
                    url: "/ajax/generate_scores.php",
                    type: "GET",
                    async: false,
                    cache: false,
                    dataType: "json",
                    success: function (response) {
                        participantsArray[participantsArray.length - 1].score = response.score;
                        updateTable();
                    },
                    error: function (response) {
                        console.log(response);
                        showError("Ошибка при получении очков");
                    }
                });
            }
        }
  
      $("#participants").val("");
    });
  
    function updateTable() {
        var tableBody = $("#participantsTable tbody");
        tableBody.empty();
        for (var i = 0; i < participantsArray.length; i++) {
            var participant = participantsArray[i];
            var tableRow = `<tr><td>${participant.id}</td><td>${participant.name}</td><td>${participant.score}</td></tr>`;
            tableBody.append(tableRow);
        }
    }

    // Обработчик события для сортировки столбцов
    $("#participantsTable th").on("click", function() {
        var column = $(this).index();
        var dataType = $(this).data("sort");
  
        var rows = $("#participantsTable tbody tr").toArray().sort(function(a, b) {
          var valueA = $(a).find("td").eq(column).text();
          var valueB = $(b).find("td").eq(column).text();
  
          if (dataType === "number") {
            return Number(valueA) - Number(valueB);
          }
          else {
            return valueA.localeCompare(valueB);
          }
        });
  
        $("#participantsTable tbody").empty().append(rows);
      });
  
    function showError(message) {
        $("#errorText").text(message);
        $("#errorModal").modal("show");
    }
});