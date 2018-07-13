package com.example.tulio.tcc;

import android.content.Intent;
import android.graphics.Color;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.text.TextUtils;
import android.view.Menu;
import android.view.MenuInflater;
import android.view.MenuItem;
import android.view.View;
import android.widget.EditText;
import android.widget.Toast;

import com.example.tulio.tcc.API.ComensaAPI;
import com.example.tulio.tcc.Model.MensalistaModel;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

import static com.example.tulio.tcc.API.ComensaAPI.retrofit;

/**
 * Created by TULIO on 12-Jul-18.
 */

public class TrocarSenhaActivity extends AppCompatActivity {

    private MensalistaModel usuario;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.troca_senha);

        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
        toolbar.setNavigationIcon(R.drawable.seta_voltar);
        toolbar.setTitleTextColor(Color.WHITE);
        setSupportActionBar(toolbar);
        toolbar.inflateMenu(R.menu.menu_main);
        getSupportActionBar().setTitle("Comensa");
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        getSupportActionBar().setDisplayShowHomeEnabled(true);
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        super.onCreateOptionsMenu(menu);
        MenuInflater inflater = getMenuInflater();
        inflater.inflate(R.menu.menu_main, menu);
        return true;
    }

    public void trocar(View view) {
        EditText edtSenha = (EditText) findViewById(R.id.editText_tSenha);
        EditText edtSenhaNova = (EditText) findViewById(R.id.editText_tSenhaNova);

        edtSenha.setError(null);
        edtSenhaNova.setError(null);

        String senha = edtSenha.getText().toString();
        final String senhaNova = edtSenhaNova.getText().toString();

        boolean cancelar = false;
        View focusView = null;

        usuario = new MensalistaModel();

        if (TextUtils.isEmpty(senha)) {
            edtSenha.setError(getString(R.string.erro_campo_obrigatório));
            focusView = edtSenha;
            cancelar = true;
        } else if (!senha.equals(usuario.getSenha())) {
            edtSenha.setError("Senha incorreta");
            focusView = edtSenha;
            cancelar = true;
        }
        if (TextUtils.isEmpty(senhaNova)) {
            edtSenha.setError(getString(R.string.erro_campo_obrigatório));
            focusView = edtSenhaNova;
            cancelar = true;
        } else if (!senhaValida(senhaNova)) {
            edtSenha.setError(getString(R.string.erro_senha_invalida));
            focusView = edtSenhaNova;
            cancelar = true;
        }

        if (cancelar) {
            // Houve erro no preenchimento dos campos
            // Não prosseguir com o login e focar nos campos inválidos
            focusView.requestFocus();
        } else {
            final MensalistaModel mensa = new MensalistaModel();

            ComensaAPI comensaAPI = retrofit.create(ComensaAPI.class);
            Call<String> call = comensaAPI.trocaSenha(senhaNova,mensa.getIdMensa());

            call.enqueue(new Callback<String>() {
                @Override
                public void onResponse(Call<String> call, Response<String> response) {

                    if(response.isSuccessful()) {
                        if(response.body().equals("false")) {
                            System.out.println("Deu errado");
                        } else {
                            mensa.setSenha(senhaNova);
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

    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle item selection
        switch (item.getItemId()) {
            case R.id.Logout:
                usuario.setTemSessao(false);
                Intent intent = new Intent(getApplicationContext(), LoginActivity.class);
                startActivity(intent);
                finish();
            case android.R.id.home:
                finish();
                return true;
            default:
                return super.onOptionsItemSelected(item);
        }
    }
}
