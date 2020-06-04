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

const num_solicitacao = document.querySelectorAll('#solicitacao-bloco');
if(num_solicitacao.length > 0){
  solicitacao.style.textShadow = "0px 0px 10px #23F0C7";
}