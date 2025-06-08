function showDeletePopup(id) {
  const popup = document.getElementById("deletePopup");
  popup.style.display = "flex";

  // Link ke file PHP untuk hapus data (misal delete.php?id=...)
  const confirmButton = document.getElementById("confirmDelete");
  confirmButton.href = "delete.php?id=" + id;
}

function hideDeletePopup() {
  const popup = document.getElementById("deletePopup");
  popup.style.display = "none";
}
