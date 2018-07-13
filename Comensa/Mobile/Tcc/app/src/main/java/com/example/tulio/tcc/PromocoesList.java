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

public class PromocoesList extends ArrayAdapter<String> {

    private final Activity context;
    private final List<String> nome;
    private final List<String> data_ini;
    private final List<String> data_fim;
    private final List<String> descricao;

    public PromocoesList(Activity context,
                        List<String> no, List<String> di, List<String> df, List<String> de) {
        super(context, R.layout.list_promocoes, no);
        this.context = context;
        this.nome = no;
        this.data_ini = di;
        this.data_fim = df;
        this.descricao = de;
    }

    @Override
    public View getView(int position, View view, ViewGroup parent) {
        LayoutInflater inflater = context.getLayoutInflater();
        View rowView = inflater.inflate(R.layout.list_promocoes, null, true);
        TextView txtNome = (TextView) rowView.findViewById(R.id.mocao_nome);
        TextView txtData_ini = (TextView) rowView.findViewById(R.id.mocao_dataIni);
        TextView txtData_fim = (TextView) rowView.findViewById(R.id.mocao_dataFim);
        TextView txtDes = (TextView) rowView.findViewById(R.id.mocao_descricao);

        txtNome.setText(nome.get(position));
        txtData_ini.setText(data_ini.get(position));
        txtData_fim.setText(data_fim.get(position));
        txtDes.setText(descricao.get(position));

        return rowView;
    }
}
