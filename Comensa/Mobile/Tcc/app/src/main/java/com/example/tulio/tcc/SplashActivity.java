package com.example.tulio.tcc;

import android.content.Intent;
import android.graphics.drawable.AnimationDrawable;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.widget.ImageView;

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

import rx.Subscriber;
import rx.android.schedulers.AndroidSchedulers;
import rx.schedulers.Schedulers;

import static com.example.tulio.tcc.API.ComensaAPI.retrofit;

/**
 * Created by TULIO on 05-Sep-17.
 */

public class SplashActivity extends AppCompatActivity {

    private ComensaDB db;
    private ComensaAPI comensaAPI = retrofit.create(ComensaAPI.class);
    final MensalistaModel usuario = new MensalistaModel();

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_splash);

        // Barra de progresso
        ImageView progBar = (ImageView) findViewById(R.id.progBar);
        AnimationDrawable anim = (AnimationDrawable) progBar.getDrawable();
        anim.start();

        if (!usuario.isTemSessao()) {
            Intent intent = new Intent(getApplicationContext(), LoginActivity.class);
            startActivity(intent);
            finish();
        } else {
            atualizaBanco();
        }
    }

    @Override
    protected void onDestroy() {
        super.onDestroy();
    }


    public void atualizaBanco() {
        //Deleta as informacoes antigas e insere as novas
        db = db.getInstance();

        db.deletar("Estabelecimento", "");
        db.deletar("Endereco", "");
        db.deletar("Contas", "");
        db.deletar("Produto", "");
        db.deletar("Promocao", "");

        comensaAPI.iniciando(usuario.getIdMensa())
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
