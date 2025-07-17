function Menu() {
  const body = document.body

  const panel = document.createElement("header");
  panel.setAttribute("class", "header-container");
  body.appendChild(panel) /*cria o header na página html*/ 

  const image = document.createElement("img");
  image.setAttribute("src","assets/fish.jpg.jpg");
  image.setAttribute("class", "logo") 
  panel.appendChild(image);/*logo do site*/ 

  const headerText = document.createElement("div");
  headerText.setAttribute("class", "header-text");
  panel.appendChild(headerText)
  const link = document.createElement("a");
  const title = document.createElement("h1");
  link.setAttribute("href", "index.html");
  link.textContent = "Mesa do Marujo";
  headerText.appendChild(title);
  title.appendChild(link);
  headerText.appendChild(link); /*Título do site, o nome */

  /*menu do site, capaz de abrir e fechar */
  const navigation = document.createElement("div");
  navigation.setAttribute("id","Sidenav");
  navigation.setAttribute("class","sidenav");
  panel.appendChild(navigation);

  const list = document.createElement("a");
  list.setAttribute("href",window.location.pathname); /*window.location.pathname utiliza da página que está aberta no presente*/
  list.setAttribute("class","closebtn");
  list.setAttribute("onclick","closeNav()");
  list.innerHTML = "&times;";
  navigation.appendChild(list);

  const space =  document.createElement("a");
  space.textContent=" ";
  navigation.appendChild(space);

  const space2 =  document.createElement("a");
  space2.textContent=" ";
  navigation.appendChild(space2);

  const listItem1 =  document.createElement("a");
  listItem1.setAttribute("href","register.html");
  listItem1.textContent="Cadastro";
  navigation.appendChild(listItem1);

  const listItem2 =  document.createElement("a");
  listItem2.setAttribute("href","menu.html");
  listItem2.textContent="Cardápio";
  navigation.appendChild(listItem2);

  const listItem3 =  document.createElement("a");
  listItem3.setAttribute("href","booking.html");
  listItem3.textContent="Reservas";
  navigation.appendChild(listItem3);

  const listItem4 =  document.createElement("a");
  listItem4.setAttribute("href","gallery.html");
  listItem4.textContent="Galeria";
  navigation.appendChild(listItem4);

  const listItem5 =  document.createElement("a");
  listItem5.setAttribute("href","rating.html");
  listItem5.textContent="Avaliações";
  navigation.appendChild(listItem5);

  const listItem6 =  document.createElement("a");
  listItem6.setAttribute("href","contact.html");
  listItem6.textContent="Contato";
  navigation.appendChild(listItem6);

  const menuBar = document.createElement("div");
  menuBar.setAttribute("id","menu");
  panel.appendChild(menuBar);

  const menuIcon = document.createElement("span");
  menuIcon.setAttribute("style", "font-size:30px;cursor:pointer");
  menuIcon.setAttribute("onclick","openNav()")
  menuIcon.innerHTML = "&#9776;";
  menuBar.appendChild(menuIcon);

}

function openNav() {
    document.getElementById("Sidenav").style.width = "250px";
    
  }
  
  function closeNav() {
    document.getElementById("Sidenav").style.width = "0";
  }
 