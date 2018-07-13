package com.example.tulio.tcc;

import android.app.Activity;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.TextView;

import java.util.List;

/**
 * Created by TULIO on 23-Oct-17.
 */

public class ProdutosList  extends ArrayAdapter<String> {

    private final Activity context;
    private final List<String> nome;
    private final List<String> preco;
    private final List<String> descricao;

    public ProdutosList(Activity context,
                        List<String> no, List<String> pr, List<String> de) {
        super(context, R.layout.list_produtos, no);
        this.context = context;
        this.nome = no;
        this.preco = pr;
        this.descricao = de;
    }

    @Override
    public View getView(int position, View view, ViewGroup parent) {
        LayoutInflater inflater = context.getLayoutInflater();
        View rowView = inflater.inflate(R.layout.list_produtos, null, true);
        TextView txtNome = (TextView) rowView.findViewById(R.id.pro_nome);
        TextView txtPreco = (TextView) rowView.findViewById(R.id.pro_preco);
        TextView txtDes = (TextView) rowView.findViewById(R.id.pro_descricao);

        txtNome.setText(nome.get(position));
        txtPreco.setText(preco.get(position));
        txtDes.setText(descricao.get(position));

        return rowView;
    }
}
