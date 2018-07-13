package com.example.tulio.tcc;

import android.content.ContentValues;
import android.content.Intent;
import android.database.Cursor;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.text.TextUtils;
import android.util.Log;
import android.view.View;
import android.widget.EditText;
import android.widget.TextView;

import com.example.tulio.tcc.API.ComensaAPI;
import com.example.tulio.tcc.BD.ComensaDB;
import com.example.tulio.tcc.Model.ContasModel;
import com.example.tulio.tcc.Model.EnderecoModel;
import com.example.tulio.tcc.Model.EstabelecimentoModel;
import com.example.tulio.tcc.Model.MensalistaModel;
import com.example.tulio.tcc.Model.ProdutoModel;
import com.example.tulio.tcc.Model.PromocaoModel;
import com.example.tulio.tcc.Model.Refresh;

import java.util.ArrayList;

import rx.Observable;
import rx.Subscriber;
import rx.android.schedulers.AndroidSchedulers;
import rx.schedulers.Schedulers;

import static com.example.tulio.tcc.API.ComensaAPI.retrofit;
import static java.lang.Thread.currentThread;

public class LoginActivity extends AppCompatActivity {

    private ComensaDB db;
    private ComensaAPI comensaAPI = retrofit.create(ComensaAPI.class);

    EditText edtUsername;
    EditText edtSenha;
    TextView erroLogin;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);

        edtUsername = (EditText) findViewById(R.id.editText_Usuario);
        edtSenha = (EditText) findViewById(R.id.editText_Senha);
        erroLogin = (TextView) findViewById(R.id.textView_Erro);
    }

    public void login(View view) {
        // Reseta os erros
        edtUsername.setError(null);
        edtSenha.setError(null);

        // Passa os valores do EditText pra String e guarda
        String username = edtUsername.getText().toString();
        String senha = edtSenha.getText().toString();

        boolean cancelar = false;
        View focusView = null;

        // Checa se o campo Senha está vazio
        if (TextUtils.isEmpty(senha)) {
            edtSenha.setError(getString(R.string.erro_campo_obrigatório));
            focusView = edtSenha;
            cancelar = true;
        }

        // Checa se o campo Usuário está vazio
        if (TextUtils.isEmpty(username)) {
            edtUsername.setError(getString(R.string.erro_campo_obrigatório));
            focusView = edtUsername;
            cancelar = true;
        }

        if (cancelar) {
            // Houve erro no preenchimento dos campos
            // Não prosseguir com o login e focar nos campos inválidos
            focusView.requestFocus();
        } else {
            // Checa se usuário existe no banco de dados e faz validação dos dados
            db = db.getInstance();
            Cursor c = db.buscar("Mensalista", new String[]{"UserMensa", "Senha"}, "UserMensa = '" + username + "'", "");


            if (c.getCount() == 0) {
                verificaUsuario(username, senha);
            } else {
                c.moveToPosition(0);
                int idS = c.getColumnIndex("Senha");

                if (c.getString(idS).equals(senha)) {
                    // Usuário existe e senha está correta
                    ContentValues valores = new ContentValues();
                    valores.put("TemSessao", "sim");

                    db.atualizar("Mensalista", valores, "UserMensa = '" + username + "'");

                    c.close();
                    Intent intent = new Intent(getApplicationContext(), ListaEstabActivity.class);
                    startActivity(intent);
                    finish();
                } else {
                    // Senha está incorreta
                    erroLogin.setText(R.string.erro_senha_incorreta);
                }
            }

        }
    }

    public void cadastraUsuario(View view) {
        Intent intent = new Intent(getApplicationContext(), CadastroActivity.class);
        startActivity(intent);
        finish();
    }

    @Override
    protected void onDestroy() {
        super.onDestroy();
    }

    public void verificaUsuario(String username, String senha) {

        comensaAPI.verUsuario(username, senha)
                .subscribeOn(Schedulers.newThread())
                .observeOn(AndroidSchedulers.mainThread())
                .subscribe(new Subscriber<MensalistaModel>() {
                    @Override
                    public void onCompleted() {
                    }

                    @Override
                    public void onError(Throwable e) {

                    }

                    @Override
                    public void onNext(MensalistaModel mensalistaModel) {
                        if(mensalistaModel.getIdMensa() == -2){
                            // Usuário não existe
                            erroLogin.setText(R.string.erro_usuario_inexistente);
                        }
                        else if(mensalistaModel.getIdMensa() == -1) {
                            // Senha está incorreta
                            erroLogin.setText(R.string.erro_senha_incorreta);
                        }
                        else {
                            atualizaBanco(mensalistaModel);
                            mensalistaModel.inserirBd();
                        }
                    }
                });
    }

    public void atualizaBanco(MensalistaModel m) {
        //Deleta as informacoes antigas e insere as novas
        db = db.getInstance();

        db.deletar("Estabelecimento", "");
        db.deletar("Endereco", "");
        db.deletar("Contas", "");
        db.deletar("Produto", "");
        db.deletar("Promocao", "");

        comensaAPI.iniciando(m.getIdMensa())
                .subscribeOn(Schedulers.newThread())
                .observeOn(AndroidSchedulers.mainThread())
                .subscribe(new Subscriber<Refresh>() {
                    @Override
                    public void onCompleted() {
                        Intent intent = new Intent(getApplicationContext(), ListaEstabActivity.class);
                        startActivity(intent);
                        finish();
                    }

                    @Override
                    public void onError(Throwable e) {

                    }

                    @Override
                    public void onNext(Refresh refresh) {
                        refresh.inserirBd();
                    }
                });
    }
}

