## Feladat (50 pont)

A beadandó feladat során egy egyszerűsített egy játékos módú, körökre osztott, arcade típusú harcolós játékot kell elkészítened Laravel keretrendszer használatával.

Szeretnénk, ha a feladatot alapvetően kellő **alkotói szabadsággal** fognátok meg, nem pedig kőbe vésett dologként. Lényegében minden (tiszta módon keletkezett) megoldás elfogadható, amíg az alább részletezett követelményeket teljesíti; tehát abban, ami nincs a továbbiakban specifikálva, **teljesen szabadon** mozoghattok. Érdemes jól tanulmányozni az elvárásokat, ugyanis **csak az ér pontot, amit expliciten leírtunk** a pontozásban; a kurzus teljesítése szempontjából tehát felesleges egy túlgondolt/bonyolultabb feladatot megoldani, persze mindig örülünk, ha extra szorgalmasak vagytok. :)

A feladathoz **kötelező kiinduló csomag nincs**, javasolt azonban a **Laravel Breeze** használata, amely a frontend beüzemelésen felül a hitelesítés alapját is biztosítja.

### Checklist

A gyorsabb és egyszerűbb ellenőrzés érdekében jelöld be egy "X"-el, hogy mely feladatokat teljesítetted! Ezt másold be a beadandód `README.md` fájljába!

[X] - Adatbázis és modellek 3 pont \
[X] - Seeder 3 pont \
[X] - Főoldal 2 pont \
[X] - Karakterek listázása oldal 2 pont \
[X] - Karakter részletes adatai tartalmazó oldal 2 pont \
[X] - Új karakter létrehozása 6 pont \
[X] - Karakter módosítása 4 pont \
[X] - Karakter törlése 2 pont \
[X] - Új mérkőzés létrehozása 3 pont \
[X] - Mérkőzés oldal 10 pont \
[X] - Helyszínek listázása oldal 2 pont \
[X] - Új helyszín létrehozása 2 pont \
[X] - Helyszín módosítása 3 pont \
[X] - Helyszín törlése 2 pont

### Adatbázis (3 pont)

Készítsd el a megfelelő adatbázis táblákat és modelleket az alábbiak szerint *(az alapvető mezők (id, created_at, updated_at) minden táblában szerepeljenek)*:

**Modellek:**
- User
  - ez a Laravel alapértelmezett táblája, egy mezőt kell hozzáadni:
    - admin [boolean] - adminisztrátor-e (alapértelmezett: `false`)
- Character - a felhasználók karakterei és az ellenséges, nem játékos karakterek
  - name [string] - a karakter neve
  - enemy [boolean] - nem játszható ellenséges karakter-e (alapértelmezett: `false`)
  - defence [integer] - védekező képesség (minimum: `0`, maximum: `3`)
  - strength [integer] - támadó képesség (minimum: `0`, maximum: `20`)
  - accuracy [integer] - pontosság képesség (minimum: `0`, maximum: `20`)
  - magic [integer] - mágikus képesség (minimum: `0`, maximum: `20`)
  - *a képességpontok (defence, strength, accuracy, magic) összege nem haladhatja meg a `20`-at*
- Place - a játéktér helyszínei
  - name [string] - a helyszín neve
  - kép a helyszínről
- Contest - a felhasználók mérkőzései
  - win [boolean] - a felhasználó nyert-e a mérkőzésen (nullable)
  - history - a mérkőzés története (a megvalósítást szabadon te választhatod meg; pl.: JSON, string, stb.)

**Kapcsolatok:**

- User `1 : N` Character
  - egy felhasználó több karaktert is létrehozhat, de egy karakter csak egy felhasználóhoz tartozhat
- User `1 : N` Contest
  - egy felhasználónak több mérkőzésen is részt vehet egy karaktere, de egy mérkőzésben csak egy felhasználó vehet részt (egyszemélyes a játék)
- Place `1 : N` Contest
  - egy mérkőzésnek csak egy helyszíne lehet, de egy helyszínen több mérkőzés is zajlhat
- Character `N : M` Contest
  - egy karakter több mérkőzésen is részt vehet és egy mérkőzésen mindig két karakter vesz részt
  - a kapcsolótábla tartalmazza a következő mezőket az `N : M` kapcsolathoz szükséges idegen kulcsokon kívül:
    - hero_hp [float] - a felhasználó karakterének életereje (minimum: `0`, maximum: `20`, alapértelmezett: `20`)
    - enemy_hp [float] - az ellenséges karakter életereje (minimum: `0`, maximum: `20`, alapértelmezett: `20`)


### Seeder (3 pont)

Készíts egy seedert, ami feltölti az adatbázist!

Ügyelj arra, hogy a seeder:
- minden eshetőségre fel legyen készítve, tehát kezelje a kapcsolatokat, illetve
- konzisztens adatokat generáljon, tehát pl. a karakterek képességpontszámainak összege ne haladja meg a 20-at; győzelem vagy vereség esetén a vesztes karakter életereje legyen `0`; ellenséges karakter csak admin felhasználó alatt legyen stb.
- a `history` mezőnek nem kell konzisztensnek lennie az életerők változását illetően

Fontos továbbá, hogy:
- ne beégetett adatokat használj, hanem generáld őket pl. _faker_ használatával
- **nem kell rengeteg adatot generálni** - csak néhányat, amennyi elég a teszteléshez

### Főoldal (2 pont)

A főoldalon jelenjen meg egy rövid ismertető szöveg a játékról, valamint jelenítsd meg a következő statisztikákat:
 - a játékban létrehozott karakterek száma
 - az eddigi mérkőzések száma
Csak ez az oldal érhető el nem bejelentkezett felhasználók számára is.

### Karakterek listázása oldal (2 pont)

Bejelentkezést követően automatikusan irányítsd át a felhasználót a saját karaktereinek listázására. Itt jelenjen meg egy táblázat, amiben a a karakterek neve, védekező, támadó, pontosság és mágikus képességpontszámai szerepelnek. A táblázatban legyen lehetőség átnavigálni a karakter részletes adatait tartalmazó oldalra.

### Karakter részletes adatai tartalmazó oldal (2 pont)

Jelenítsd meg a karakter minden adatát (név, védekező, támadó, pontosság és mágikus képességpontszámok). Továbbá egy listában jelenítsd meg a karakter mérkőzéseit is (helyszín és ellenfél neve). A mérkőzésre kattintva navigáld át a felhasználót a mérkőzés oldalra.
Az oldalon legyen lehetőség a karakter szerkesztésére és törlésére.
Az oldalon szerepeljen egy gomb, amivel új mérkőzést indíthat a felhasználó.
Az oldal csak a karaktert létrehozó felhasználó számára legyen elérhető.

### Új karakter létrehozása (6 pont)

Jeleníts meg egy űrlapot, ahol a felhasználó egy új karaktert tud létrehozni. A küldést követően végezd el a megfelelő validációkat a **Modellek** részben leírtak szerint, illetve a tulajdonságpontok (defence, strength, accuracy és magic) összegének 20-nak kell lennie.
Az `admin` felhasználók is képesek saját karaktereket létrehozni, de nekik jelenjen meg egy mező, ahol ellenséges karakterként tudják létrehozni a karaktert (azaz a `enemy` mező értékét `true`-ra tudják állítani).

### Karakter módosítása (4 pont)

Jeleníts meg egy űrlapot, ahol a felhasználó módosíthatja a karakter adatait. A küldést követően végezd el a megfelelő validációkat a **Modellek** részben leírtak szerint. A felhasználó csak a saját karakterét tudja módosítani.
Az `admin` felhasználók a saját karaktereiken túl képesek az ellenséges karaktereket is módosítani (amelyeknél az `enemy` mező `true`).

### Karakter törlése (2 pont)

Legyen lehetőség a karakter törlésére. A felhasználó csak a saját karakterét tudja törölni.
Az `admin` felhasználók a saját karaktereiken túl képesek az ellenséges karaktereket is törölni (amelyeknél az `enemy` mező `true`).

### Új mérkőzés létrehozása (3 pont)

Ha a felhasználó az egyik karakter részletező oldalán kiválasztja az új mérkőzés indítását, akkor készüljön egy új mérkőzés (`Contest`). A helyszín és az ellenfél véletlenszerűen legyenek kiválasztva. A létrehozást követően a felhasználó automatikusan kerüljön átirányításra a mérkőzés oldalára.
Két karakter között több mérkőzés is lehetséges, akár szimultán is :)

### Mérkőzés oldal (10 pont)

A mérkőzés oldalon jelenjen meg a helyszín neve és az oldal háttérképe legyen a helyszínhez feltöltött kép.
Az oldalon jelenjenek meg a karakterek statjai (defence, strength, accuracy, magic), valamint az életerejük (`hero_hp`/`enemy_hp`). A felhasználó karakterének és az ellenfél karakterének cselekedetei is jelenjenek meg (`history`). 
Az oldalon legyen három gomb, melyek segítségével a felhasználó kiválaszthatja a következő támadását: melee, ranged vagy special (magic).
Amennyiben a mérkőzés már véget ért (`win` mező nem null), akkor jelenítsd meg a végeredményt (győzelem vagy vereség) és ebben az esetben ne jelenjenek meg a támadó gombok.

**Egy forduló menete:**

- A mérkőzés kezdetén mindkét karakternek az életereje legyen `20`.
- A felhasználó a három támadó gomb segítségével kiválasztja a következő cselekedetét.
- Ha a mézkőzés már véget ért, akkor ne történjen semmi.
- A kiválasztott támadás hatására számítsd ki a sérülés pontértékét a **Sérülés pontszámának kiszámítása** részben leírtak szerint.
- Frissítsd az adatbázisban az ellenséges karakter életerejét (ha negatív lenne, akkor legyen `0`) és a karakterek cselekedeteihez (`history`) add hozzá a támadást.
    - pl.: `CHARACTER_NAME: melee attack - 5 damage`
- Ellenőrzid, hogy a mérkőzés véget ért-e (az ellenség karakterének életereje (`enemy_hp`) `0`).
    - Ha igen, állítsd a mérkőzés `win` mezőjét `true`-ra és irányítsd vissza a felhasználót a mérkőzés oldalra.
    - Ha nem, akkor az ellenség karaktere következik.
- Az ellenség karaktere véletlenszerűen válasszon támadást. Innentől kezdve minden ugyanúgy történik, mint fentebb a felhasználó karakterének támadásánál (sérülési pontszám kiszámítása, karakter életerejének és a `history` frissítése).
- Ellenőrzid, hogy a mérkőzés véget ért-e (a felhasználó karakterének életereje (`hero_hp`) `0`).
    - Ha igen, állítsd a mérkőzés `win` mezőjét `false`-ra.
- Irányítsd a felhasználót a mérkőzés oldalra.

**Sérülés pontszámának kiszámítása:**

Készíts egy metódust, ami kiszámítja a sérülés pontszámát a következők szeirnt:
- Paraméterek:
    - a támadás típusa (melee, ranged, special)
    - a támadó karakter (`ATT`) adatai (hp, defence, strength, accuracy, magic)
    - a védekező karakter (`DEF`) adatai (hp, defence, strength, accuracy, magic)
- Kimenet: a sérülés pontszáma (float)
- Sérülés kiszámítása:
    - Melee:           `(DEF.HP) - ((ATT.STRENGTH * 0.7 + ATT.ACCURACY * 0.1 + ATT.MAGIC * 0.1) - DEF.DEFENCE)`
    - Ranged:          `(DEF.HP) - ((ATT.STRENGTH * 0.1 + ATT.ACCURACY * 0.7 + ATT.MAGIC * 0.1) - DEF.DEFENCE)`
    - Special (magic): `(DEF.HP) - ((ATT.STRENGTH * 0.1 + ATT.ACCURACY * 0.1 + ATT.MAGIC * 0.7) - DEF.DEFENCE)`
    - Magyarul: a védekező karakter életerejéből vond ki a védekező karakter védekező képességével csökkentett támadó karakter támadó képességének súlyozott összegét.
    - **Ha a sérülés pontszám negatív lenne (nagyobb a védekező karakter védekező pontszáma (`defence`), mint a támadó karakter támadásának ereje), akkor 0-át adj vissza!**

**Tipp a megvalósításhoz:**

<details>

<summary>Tipp megtekintése – a végleges megoldás ettől eltérhet, ha megakadtál, kattints ide egy lehetséges megvalósításért</summary>

A mérkőzés oldal végpontja legyen a következő:
`GET` `/match/{id}`
A mérkőzés egy fordulójának végrehajtásához készíts egy új végpontot:
`GET` `/match/{id}/{attackType}` [a támadás típusa: melee, ranged, special; a mérkőzés azonosítója: id; a végpont neve: match.attack]

A mérkőzés oldalon a három támadó gomb legyen három link, amik a megfelelően felparaméterezett végpontokat hívják meg.
```html
<a class="..." href="{{ route('match.attack', ['id' => $match->id, 'attackType' => 'melee']) }}">Melee</a>
<a class="..." href="{{ route('match.attack', ['id' => $match->id, 'attackType' => 'ranged']) }}">Ranged</a>
<a class="..." href="{{ route('match.attack', ['id' => $match->id, 'attackType' => 'special']) }}">Special</a>
```

Az átirányítást követően fusson le az **Egy forduló menete** részben leírtak szerinti logika.
Végül a controllerben a mérkőzés oldalra irányítsd vissza a felhasználót.

</details>

### Helyszínek listázása oldal (2 pont)

Csak admin felhasználók érhetik el!
Jelenjen meg egy táblázat, amiben a helyszínek nevei és képei szerepelnek, továbbá legyen lehetőség a helyszínek szerkesztésére és törlésére.

### Új helyszín létrehozása (2 pont)

Csak admin felhasználók érhetik el!
Jeleníts meg egy űrlapot, ahol az admin felhasználó új helyszínt tud létrehozni. Kötelező képet feltölteni. A küldést követően végezd el a megfelelő validációkat a **Modellek** részben leírtak szerint.

### Helyszín módosítása (3 pont)

Csak admin felhasználók érhetik el!
Jeleníts meg egy űrlapot, ahol az admin felhasználó módosíthatja a helyszín adatait. Ekkor már nem kötelező képet feltölteni.
Ha nem került új kép feltöltésre, akkor a régi kép maradjon meg.
Ha került új kép feltöltésre, akkor a régi cserélődjön le az újra, a régit töröld ebben az esetben.

### Helyszín törlése (2 pont)

Csak admin felhasználók érhetik el!
Legyen lehetőség a helyszín törlésére, ne felejtsd el a hozzá tartozó képet is törölni!
