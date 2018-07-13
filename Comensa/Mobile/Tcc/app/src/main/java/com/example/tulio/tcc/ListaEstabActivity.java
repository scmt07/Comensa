package com.example.tulio.tcc;

import android.content.Intent;
import android.graphics.Color;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.view.Menu;
import android.view.MenuInflater;
import android.view.MenuItem;
import android.view.View;
import android.widget.ListView;
import android.widget.AdapterView;

import com.example.tulio.tcc.Model.ContasModel;
import com.example.tulio.tcc.Model.EnderecoModel;
import com.example.tulio.tcc.Model.EstabelecimentoModel;
import com.example.tulio.tcc.Model.MensalistaModel;

import java.util.ArrayList;
import java.util.List;

/**
 * Created by TULIO on 05-Sep-17.
 */

public class ListaEstabActivity extends AppCompatActivity {

    private MensalistaModel usuario;
    private ArrayList<EstabelecimentoModel> estabelecimentos = new ArrayList<EstabelecimentoModel>();
    ListView list;
    List<String> estab = new ArrayList<String>();
    List<String> ruas = new ArrayList<String>();
    List<String> telefone = new ArrayList<String>();



    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_listaestab);

        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
        toolbar.setTitleTextColor(Color.WHITE);
        setSupportActionBar(toolbar);
        toolbar.inflateMenu(R.menu.menu_main);
        getSupportActionBar().setTitle("Comensa");



        usuario = new MensalistaModel();
        ArrayList<ContasModel> contas = usuario.getContas();
        for(int i=0;i<contas.size();i++) {
            EstabelecimentoModel e = new EstabelecimentoModel(contas.get(i).getEstab());
            EnderecoModel end = new EnderecoModel(e.getEndereco());
            estabelecimentos.add(e);
            estab.add(e.getNome());
            ruas.add(end.getRua());
            telefone.add(e.getTelefone());
        }

        EstabList adapter = new
                EstabList(this, estab, ruas, telefone);

        list=(ListView)findViewById(R.id.list_estab);
        list.setAdapter(adapter);

        list.setOnItemClickListener(new AdapterView.OnItemClickListener() {

            @Override
            public void onItemClick(AdapterView<?> parent, View view,
                                    int position, long id) {
                Intent it = new Intent(getBaseContext(), DetalhesActivity.class);
                it.putExtra("Estab",estabelecimentos.get((int) id).getIdEstab());
                startActivity(it);
            }
        });

    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        super.onCreateOptionsMenu(menu);
        MenuInflater inflater = getMenuInflater();
        inflater.inflate(R.menu.menu_main, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle item selection
        switch (item.getItemId()) {
            case R.id.Logout:
                usuario.setTemSessao(false);
                Intent intent = new Intent(getApplicationContext(), LoginActivity.class);
                startActivity(intent);
                finish();
            case R.id.Senha:
                intent = new Intent(getApplicationContext(), TrocarSenhaActivity.class);
                startActivity(intent);
            default:
                return super.onOptionsItemSelected(item);
        }
    }
}
