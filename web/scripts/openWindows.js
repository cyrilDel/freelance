
function openWindow(file,tx,ty) {
  myWindow= open(file, "newWindow", "width="+tx+",height="+ty+",position=absolute,top=10,left=0,menubar=no,resizable=no,scrollbars=yes,status=no,toolbar=no");
  }
function ChangeMessage(message,champ) {
  if(document.getElementById)
  document.getElementById(champ).innerHTML = message;
  }
