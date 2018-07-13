package com.example.tulio.tcc;

import android.content.Intent;
import android.database.Cursor;
import android.graphics.Color;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.support.v7.widget.Toolbar;
import android.text.TextUtils;
import android.view.MenuItem;
import android.view.View;
import android.widget.EditText;
import android.widget.Toast;

import com.example.tulio.tcc.API.ComensaAPI;
import com.example.tulio.tcc.BD.ComensaDB;
import com.example.tulio.tcc.Model.EnderecoModel;
import com.example.tulio.tcc.Model.MensalistaModel;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

import static com.example.tulio.tcc.API.ComensaAPI.retrofit;

public class CadastroActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_cadastro);

        /* Define a barra de tarefas */
        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
        toolbar.setNavigationIcon(R.drawable.seta_voltar);
        toolbar.setTitleTextColor(Color.WHITE);
        setSupportActionBar(toolbar);
        getSupportActionBar().setTitle("Login");
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        getSupportActionBar().setDisplayShowHomeEnabled(true);
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        /* Implementa a seta de voltar à tela anterior na barra de tarefas */
        int id = item.getItemId();

        if (id == android.R.id.home) {
            Intent intent = new Intent(getApplicationContext(), LoginActivity.class);
            startActivity(intent);
            finish();
            return true;
        }
        return super.onOptionsItemSelected(item);
    }

    public void cadastrar(View view) {
        EditText edtBairro = (EditText) findViewById(R.id.editText_Bairro);
        EditText edtRua = (EditText) findViewById(R.id.editText_Rua);
        EditText edtNumero = (EditText) findViewById(R.id.editText_Numero);
        EditText edtComplemento = (EditText) findViewById(R.id.editText_Complemento);
        EditText edtCep = (EditText) findViewById(R.id.editText_Cep);
        EditText edtNome = (EditText) findViewById(R.id.editText_Nome);
        EditText edtCpf = (EditText) findViewById(R.id.editText_Cpf);
        EditText edtTelefone = (EditText) findViewById(R.id.editText_Telefone);
        EditText edtEmail = (EditText) findViewById(R.id.editText_Email);
        EditText edtUsuario = (EditText) findViewById(R.id.editText_Usuario);
        EditText edtSenha = (EditText) findViewById(R.id.editText_Senha);
        EditText edtConfSenha = (EditText) findViewById(R.id.editText_ConfirmacaoSenha);

        // Reseta os erros
        edtBairro.setError(null);
        edtRua.setError(null);
        edtNumero.setError(null);
        edtCep.setError(null);
        edtNome.setError(null);
        edtCpf.setError(null);
        edtTelefone.setError(null);
        edtEmail.setError(null);
        edtSenha.setError(null);
        edtUsuario.setError(null);
        edtConfSenha.setError(null);

        // Passa os valores do EditText pra String e guarda
        String bairro = edtBairro.getText().toString();
        String rua = edtRua.getText().toString();
        String num = edtNumero.getText().toString();
        String complemento = edtComplemento.getText().toString();
        String cep = edtCep.getText().toString();
        String nome = edtNome.getText().toString();
        String cpf = edtCpf.getText().toString();
        String telefone = edtTelefone.getText().toString();
        String email = edtEmail.getText().toString();
        String nomeUsuario = edtUsuario.getText().toString();
        String senha = edtSenha.getText().toString();
        String confSenha = edtConfSenha.getText().toString();

        boolean cancelar = false;
        View focusView = null;

        ComensaAPI comensaApi = retrofit.create(ComensaAPI.class);

        // Checa se algum dos campos está vazio
        //bairro
        if (TextUtils.isEmpty(bairro)) {
            edtBairro.setError(getString(R.string.erro_campo_obrigatório));
            focusView = edtBairro;
            cancelar = true;
        }
        //rua
        if (TextUtils.isEmpty(rua)) {
            edtRua.setError(getString(R.string.erro_campo_obrigatório));
            focusView = edtRua;
            cancelar = true;
        }
        //numero
        if (TextUtils.isEmpty(num)) {
            edtNumero.setError(getString(R.string.erro_campo_obrigatório));
            focusView = edtNumero;
            cancelar = true;
        } else if (Integer.parseInt(num) <= 0) {
            edtNumero.setError("Numero invalido");
            focusView = edtNumero;
            cancelar = true;
        }
        //cep
        if (TextUtils.isEmpty(cep)) {
            edtCep.setError(getString(R.string.erro_campo_obrigatório));
            focusView = edtCep;
            cancelar = true;
        } else if(cep.length() != 8) {
            edtCep.setError("CEP invalido");
            focusView = edtCep;
            cancelar = true;
        }
        //telefone
        if (TextUtils.isEmpty(telefone)) {
            edtTelefone.setError(getString(R.string.erro_campo_obrigatório));
            focusView = edtTelefone;
            cancelar = true;
        } else if(telefone.length() != 11 || telefone.length() != 10) {
            if(telefone.length() == 9 || telefone.length() == 8)
                edtTelefone.setError("Telefone invalido(esqueceu o DDD?)");
            else
                edtTelefone.setError("Telefone invalido");
            focusView =  edtTelefone;
            cancelar = true;
        }
        //cpf
        if (TextUtils.isEmpty(cpf)) {
            edtCpf.setError(getString(R.string.erro_campo_obrigatório));
            focusView = edtCpf;
            cancelar = true;
        } else if(cpf.length() != 11) {
            edtCpf.setError("CPF invalido");
            focusView = edtCpf;
            cancelar = true;
        }
        //email
        if (TextUtils.isEmpty(email)) {
            edtEmail.setError(getString(R.string.erro_campo_obrigatório));
            focusView = edtEmail;
            cancelar = true;
        }
        //senha
        if (TextUtils.isEmpty(senha)) {
            edtSenha.setError(getString(R.string.erro_campo_obrigatório));
            focusView = edtSenha;
            cancelar = true;
        } else if (!senhaValida(senha)) {
            edtSenha.setError(getString(R.string.erro_senha_invalida));
            focusView = edtSenha;
            cancelar = true;
        }
        //nome
        if (TextUtils.isEmpty(nome)) {
            edtNome.setError(getString(R.string.erro_campo_obrigatório));
            focusView = edtNome;
            cancelar = true;
        }
        //usuario
        if (TextUtils.isEmpty(nomeUsuario)) {
            edtUsuario.setError(getString(R.string.erro_campo_obrigatório));
            focusView = edtUsuario;
            cancelar = true;
        }
        //confSenha
        if (TextUtils.isEmpty(confSenha)) {
            edtConfSenha.setError(getString(R.string.erro_campo_obrigatório));
            focusView = edtConfSenha;
            cancelar = true;
        }
        if (!senha.equals(confSenha)) {
            edtConfSenha.setError(getString(R.string.erro_senhas_iguais));
            focusView = edtConfSenha;
            cancelar = true;
        }

        if (cancelar) {
            // Houve erro no preenchimento dos campos
            // Não prosseguir com o login e focar nos campos inválidos
            focusView.requestFocus();
        } else {
            // Coloca os valores no BD
            final MensalistaModel mensa = new MensalistaModel(nomeUsuario,cpf,senha,true);

            ComensaAPI comensaAPI = retrofit.create(ComensaAPI.class);
            Call<String> call = comensaAPI.insertMensa(bairro,rua,Integer.parseInt(num),complemento,cep,
                    nome,cpf,telefone,email,nomeUsuario,senha);

            call.enqueue(new Callback<String>() {
                @Override
                public void onResponse(Call<String> call, Response<String> response) {

                    if(response.isSuccessful()) {
                        if(response.body().equals("false")) {
                            EditText edtUsuario = (EditText) findViewById(R.id.editText_Usuario);
                            edtUsuario.setError("Usuario ja existe");
                            View focusView = edtUsuario;
                            focusView.requestFocus();
                        } else {
                            mensa.setIdMensa(Integer.parseInt(response.body()));
                            mensa.inserirBd();
                            Intent intent = new Intent(getApplicationContext(), ListaEstabActivity.class);
                            startActivity(intent);
                            finish();
                        }
                    }
                }

                @Override
                public void onFailure(Call<String> call, Throwable t) {

                }
            });
        }
    }

    private boolean senhaValida(String senha) {
        return senha.length() >= 6;
    }

    @Override
    protected void onDestroy() {
        super.onDestroy();
    }
}


