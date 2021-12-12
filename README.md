# CRUD
**Gerenciador de atividades PHP 7.1**<br><br>
*Pendências*: <br>
Reformular como as informações são retornadas no metodo 'getAtividade';<br>
Limitar caracteres da descrição na lista de atividades.<br>
Documentar códigos em js explicando as desisões tomadas.<br><br>

*Funções possiveis*: (Finalizado)<br> 
Possibilidade de adicionar novas atividades contendo um título, descrição e tipo;<br>
Listar as atividades em aberto;<br>
Marcar e desmarcar as atividades como concluídas;<br>
Listar as atividades concluídas;<br>
Editar o título, descrição e tipo de uma atividade;<br>
Remover uma atividade.<br><br>

*Regras de negócio*: (Finalizado)<br> 
Os tipos de atividades podem ser: Desenvolvimento, Atendimento, Manutenção e Manutenção urgente;<br>
Atividades de manutenção urgente não podem ser removidas, apenas finalizadas;<br>
Atividades de atendimento e manutenção urgentes não podem ser finalizadas se a descrição estiver preenchida com menos de 50 caracteres;<br>
Manutenções urgentes não podem ser criadas (nem via edição) após as 13:00 das sextas-feiras.<br><br>

*Requisitos Funcionais*: (Finalizado) <br>
O sistema deve estar protegido por um login<br>
Todas as telas do sistema só poderão ser acessadas por usuários que estejam logados<br><br>

*Requisitos Não Funcionais*: (Finalizado)<br>
O sistema deve armazenar em banco de dados, de forma segura, a senha de acesso dos usuários.<br>
