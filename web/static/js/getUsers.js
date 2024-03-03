/*
Author: Jop Molenaar 
E-mail author: jopmolenaar@icloud.com
Date: 04-10-2023
Description: This file handles a AJAX function to load data in a certain section. It also handles a POST request from a form.
*/

const loadTable = () => {
  $.ajax({
    type: "POST",
    url: "../userFiles/getUsers.php",
    data: {},
    success: function (response) {
      const userData = JSON.parse(response);

      const tableRows = userData.map((row) => {
        return `<tr>
                <td class='nameTd'>${row.name}</td>
                <td>${row.cardId}</td>
                <td><button data-idForDelete='${row.id}'>Delete</button></td>
                </tr>`;
      });
      $("#getUsers").html(tableRows.join(""));

      const deleteBtns = document.querySelectorAll("#getUsers button");
      deleteBtns.forEach((button) => {
        button.addEventListener("click", () => {
          $.ajax({
            type: "POST",
            url: "../userFiles/deleteUsers.php",
            data: {
              id: button.dataset.idfordelete,
            },
            success: function (response) {
              loadTable();
            },
          });
        });
      });
    },
  });
};
loadTable();

const submitBtn = document.querySelector("form button[name=submit]");
const text = document.querySelector("form input[name=name]");
const cardId = document.querySelector("form input[name=passnumber]");
submitBtn.addEventListener("click", () => {
  $.ajax({
    type: "POST",
    url: "../userFiles/addUsers.php",
    data: {
      name: text.value,
      card_id: cardId.value,
    },
    success: function (response) {
      loadTable();
    },
  });
});
