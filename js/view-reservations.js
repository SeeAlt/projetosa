document.addEventListener("DOMContentLoaded", loadReservations);

function loadReservations() {
  fetch('painel_data.php')
    .then(response => response.json())
    .then(data => {
      const tableBody = document.querySelector("#reservationTable tbody");
      tableBody.innerHTML = "";

      if (!data || data.length === 0) {
        tableBody.innerHTML = "<tr><td colspan='5'>Nenhuma reserva encontrada.</td></tr>";
        return;
      }

      data.forEach(res => {
        const tr = document.createElement("tr");

        const dateValue = new Date(res.reservation_datehour);
        const formattedDate = dateValue.toISOString().slice(0, 16); // yyyy-MM-ddTHH:mm

        tr.innerHTML = `
          <td>${res.reservation_local}</td>
          <td>${res.people_quantity}</td>
          <td>
            <input type="datetime-local" value="${formattedDate}" id="date-${res.id_reservation}" ${res.reservation_status !== "Andamento" ? "disabled" : ""}>
          </td>
          <td>${res.reservation_status}</td>
          <td>
            <button onclick="updateReservation(${res.id_reservation})" ${res.reservation_status !== "Andamento" ? "disabled" : ""}>Alterar</button>
            <button onclick="cancelReservation(${res.id_reservation})" ${res.reservation_status !== "Andamento" ? "disabled" : ""}>Cancelar</button>
          </td>
        `;
        tableBody.appendChild(tr);
      });
    })
    .catch(err => {
      console.error("Erro ao carregar reservas:", err);
    });
}
