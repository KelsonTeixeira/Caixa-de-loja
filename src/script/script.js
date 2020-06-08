var open = false;
const solicitacao = document.querySelector('#solicitacao');
const list = document.querySelector('.solicitacao');

solicitacao.addEventListener('click', () => {
  open = !open;
  if(open){
    list.style.display = "block";
  }else{
    list.style.display = "none";
  }
});

///////////////////////////////////////////////////////////////////////

const num_solicitacao = document.querySelectorAll('#solicitacao-bloco');

if(num_solicitacao.length > 0){
  solicitacao.style.textShadow = "0px 0px 20px #23F0C7";
}

///////////////////////////////////////////////////////////////////////////

const assisti = document.querySelector('.assisti');
const opinionForm = document.querySelector('.opiniao-form');
var formOpen = false;

assisti.addEventListener('click', () => {
  formOpen = !formOpen;
  if(formOpen){
    opinionForm.style.height = '220px';
    opinionForm.style.padding = '10px';
  }else{
    opinionForm.style.height = '0';
    opinionForm.style.padding = '0';
  }
});