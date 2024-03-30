function cart(pid)
{
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        window.location.href = 'cart.html';
        }
    xhttp.open("GET", "main.php?f=cart&p="+pid, true);
    xhttp.send();
}
function buy(pid)
{
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        window.location.href = 'orders.html';
        }
    xhttp.open("GET", "main.php?f=buy&p="+pid, true);
    xhttp.send();
}