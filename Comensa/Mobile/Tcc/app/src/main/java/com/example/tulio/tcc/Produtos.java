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
import com.example.tulio.tcc.Model.ProdutoModel;

import java.util.ArrayList;
import java.util.List;

/**
 * Created by TULIO on 21-Oct-17.
 */

public class Produtos extends Fragment {
    private MensalistaModel usuario;
    ListView list;
    List<String> nome = new ArrayList<String>();
    List<String> preco = new ArrayList<String>();
    List<String> descricao = new ArrayList<String>();

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {

        View view = inflater.inflate(R.layout.produtos, container, false);
        DetalhesActivity activity = (DetalhesActivity) getActivity();
        int estab = activity.estab;

        EstabelecimentoModel aux = new EstabelecimentoModel();

        usuario = new MensalistaModel();
        ArrayList<ContasModel> contas = usuario.getContas();
        for(int i=0;i<contas.size();i++) {
            if(contas.get(i).getEstab() == estab)
                aux = new EstabelecimentoModel(contas.get(i).getEstab());

        }
        ArrayList <ProdutoModel> produto = aux.getProdutos();

        for(int i=0;i<produto.size();i++){
            nome.add(produto.get(i).getNome());
            preco.add(produto.get(i).getPreco());
            descricao.add(produto.get(i).getDescricao());
        }

        ProdutosList adapter = new
                ProdutosList(activity, nome, preco, descricao);

        list=(ListView) view.findViewById(R.id.list_produtos);
        list.setAdapter(adapter);

        return view;
    }
}
