let client = new DataTable("#client");

client.on('datatable.sort', () => {
  toggleModals(); // g tau kenapa, cmn dia newasin
})

for (let row of client.activeRows) {
  row.addEventListener('click', () => {
    
  });
}