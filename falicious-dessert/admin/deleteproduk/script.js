function showDeletePopup(id) {
  const popup = document.getElementById("deletePopup");
  popup.style.display = "flex";

  const confirmButton = document.getElementById("confirmDelete");
  confirmButton.href = "delete.php?id=" + id;
}

function hideDeletePopup() {
  document.getElementById("deletePopup").style.display = "none";
}
