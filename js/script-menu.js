function Menu() {
  const body = document.body;

  const panel = document.createElement("header");
  panel.setAttribute("class", "header-container");
  body.prepend(panel);

  const image = document.createElement("img");
  image.setAttribute("src", "assets/fish.jpg.jpg");
  image.setAttribute("class", "logo");
  panel.appendChild(image);

  const headerText = document.createElement("div");
  headerText.setAttribute("class", "header-text");
  panel.appendChild(headerText);

  const link = document.createElement("a");
  const title = document.createElement("h1");
  link.setAttribute("href", "index.html");
  link.textContent = "Mesa do Marujo";
  headerText.appendChild(title);
  title.appendChild(link);

  const navigation = document.createElement("div");
  navigation.setAttribute("id", "Sidenav");
  navigation.setAttribute("class", "sidenav");
  panel.appendChild(navigation);

  const closeBtn = document.createElement("a");
  closeBtn.setAttribute("href", window.location.pathname);
  closeBtn.setAttribute("class", "closebtn");
  closeBtn.setAttribute("onclick", "closeNav()");
  closeBtn.innerHTML = "&times;";
  navigation.appendChild(closeBtn);

  const menuItems = [
    { text: "  " },
    { text: "  " },
    { href: "index.html", text: "Início" },
    { href: "register.html", text: "Cadastro", id: "registerLink" },
    { href: "booking.html", text: "Reservas" },
    { href: "gallery.html", text: "Galeria" },
    { href: "rating.html", text: "Avaliações" },
    { href: "contact.html", text: "Contato" },
    { href: "view-reservations.html", text: "Minhas Reservas" },
  ];

  menuItems.forEach(item => {
    const a = document.createElement("a");
    if (item.href) a.setAttribute("href", item.href);
    a.textContent = item.text;
    if (item.id) a.setAttribute("id", item.id);
    navigation.appendChild(a);
  });

  const menuBar = document.createElement("div");
  menuBar.setAttribute("id", "menu");
  panel.appendChild(menuBar);

  const menuIcon = document.createElement("span");
  menuIcon.setAttribute("style", "font-size:30px;cursor:pointer");
  menuIcon.setAttribute("onclick", "openNav()");
  menuIcon.innerHTML = "&#9776;";
  menuBar.appendChild(menuIcon);

  // Apenas UMA fetch para evitar duplicidade
  fetch('check-admin.php')
    .then(res => res.json())
    .then(data => {
      if (data.logged === 1) {
        // Remove link Cadastro
        const registerLink = document.getElementById("registerLink");
        if (registerLink) registerLink.remove();

        // Adiciona link Logout
        const logoutLink = document.createElement("a");
        logoutLink.setAttribute("href", "logout.php");
        logoutLink.textContent = "Sair";
        navigation.appendChild(logoutLink);
      }

      // Se admin, adiciona link Painel do Admin
      if (data.logged === 1 && data.is_admin === 1) {
        const adminLink = document.createElement("a");
        adminLink.setAttribute("href", "admin-painel.php"); // Corrigido aqui
        adminLink.textContent = "Painel do Admin";
        navigation.appendChild(adminLink);
      }
    })
    .catch(err => {
      console.error("Erro ao verificar sessão:", err);
    });
}


function openNav() {
    document.getElementById("Sidenav").style.width = "250px";
    
  }
  
  function closeNav() {
    document.getElementById("Sidenav").style.width = "0";
  }