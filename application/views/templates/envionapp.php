
  <section class="content">
            <div class ="contato">
                <h2>Preencha o formulário abaixo</h2>
                <form class="form" method="POST" action="./email.php">
                    <input class="field" name="name" placeholder="Seu nome">
                    <input class="field" name="email" placeholder="seuemail@seudominio">
                    <textarea class="field" name="messagem" placeholder="Digite sua mensagem aqui.."></textarea>
                    <input class="field" type="submit" value="Enviar">

                </form>
            </div>
        </section>

   
        <style>
          
            .content{
                display: flex; justify-content: right;
            }
            .contato{
                width: 100%;
                max-width: 500px;
            }
            .form{
                display: flex;
                flex-direction: column;
            }
            .field{
                padding: 10px;
                margin-bottom: 15px;
                border: 1px solid #ddd;
                border-radius: 5px;
                font-family: Arial, Helvetica, sans-serif;    
                font-size: 16px;
            }
        </style>
  


      
  
