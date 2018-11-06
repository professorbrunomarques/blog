function responder(nome, id){
    document.getElementById('replyto_text').innerText= "Respondendo para: "+nome; 
    document.getElementById('replyto_text').style.display='block'; 
    document.getElementById('replyto').value=id;
    document.getElementById('btn_submit').value = "Enviar Resposta"
    document.getElementById('btn_reset').style.display='inline-block'; 
    document.getElementById('comment_user').focus();
}
function cancelReply(){
    document.getElementById('replyto_text').style.display='none';
    document.getElementById('btn_submit').value = "Enviar Comentário";
    document.getElementById('btn_reset').style.display='none'; 
}

$(document).ready(function() {
    $('.toggle-menu > button').click(function(){
        $('.header-menu .menu').slideToggle();
    });
});