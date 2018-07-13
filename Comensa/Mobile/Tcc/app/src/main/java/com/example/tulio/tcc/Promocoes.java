package com.example.tulio.tcc;

import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ListView;

import com.example.tulio.tcc.Model.ContasModel;
import com.example.tulio.tcc.Model.EstabelecimentoModel;
import com.example.tulio.tcc.Model.MensalistaModel;
import com.example.tulio.tcc.Model.PromocaoModel;

import java.util.ArrayList;
import java.util.List;

/**
 * Created by TULIO on 21-Oct-17.
 */

public class Promocoes extends Fragment {
    private MensalistaModel usuario;
    ListView list;
    List<String> nome = new ArrayList<String>();
    List<String> data_ini = new ArrayList<String>();
    List<String> data_fim = new ArrayList<String>();
    List<String> descricao = new ArrayList<String>();

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.promocoes, container, false);
        DetalhesActivity activity = (DetalhesActivity) getActivity();
        int estab = activity.estab;

        EstabelecimentoModel aux = new EstabelecimentoModel();

        usuario = new MensalistaModel();
        ArrayList<ContasModel> contas = usuario.getContas();
        for(int i=0;i<contas.size();i++) {
            if(contas.get(i).getEstab() == estab)
                aux = new EstabelecimentoModel(contas.get(i).getEstab());

        }
        ArrayList <PromocaoModel> promocao = aux.getPromocoes();

        for(int i=0;i<promocao.size();i++){
            nome.add(promocao.get(i).getNome());
            data_ini.add(promocao.get(i).getData_ini());
            data_fim.add(promocao.get(i).getData_fim());
            descricao.add(promocao.get(i).getDescricao());
        }

        PromocoesList adapter = new
                PromocoesList(activity, nome, data_ini, data_fim, descricao);

        list=(ListView) view.findViewById(R.id.list_promocoes);
        list.setAdapter(adapter);

        return view;
    }
}
