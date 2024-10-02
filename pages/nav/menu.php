

<link rel="stylesheet" href="../css/menu.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">


<div class="off-screen-menu" onclick="toggleMenu2()" >
    <ul>
        <li><a class="menugomb" href="home">Home</a></li>
        <li><a class="menugomb" href="uzenofal">Üzenőfal</a></li>
        <li><a class="menugomb" href="kapcsolat">Kapcsolat</a></li>
        
    </ul>

    </div>
    
<nav>
    
    <div class="centered-image-container">
        <a  href="../pages/home"><img src="../img/TAppancs_logo.png" alt="Logo"></a>
    </div>

    <div>

        <a id="myLink" href="login"><i class="fas fa-user" id="login" ></i></a>
        

    </div>



    <div class="ham-menu" onclick="toggleMenu()">
    
        <span></span>
        <span></span>
        <span></span>

    </div>
</nav>


<script>
function toggleMenu() {
    var link = document.getElementById('myLink');
    
    // Ha a link látszik, akkor gombnyomásra tünjön el
    if (link.style.display === 'inline' || link.style.display === '') {
        link.style.display = 'none'; // Elrejtés
    } else {
        
        setTimeout(function() {
            link.style.display = 'inline';
        }, 200);
         // Megjelenítés 200ms után
    }
}

</script>

