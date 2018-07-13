package com.example.tulio.tcc;

import android.app.Activity;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.ImageView;
import android.widget.TextView;

import java.util.List;

/**
 * Created by TULIO on 05-Sep-17.
 */

public class EstabList extends ArrayAdapter<String> {

    private final Activity context;
    private final List<String> estab;
    private final List<String> ruas;
    private final List<String> telefone;

    public EstabList(Activity context,
                      List<String> es, List<String> ru, List<String> tel) {
        super(context, R.layout.list_estabelecimento, es);
        this.context = context;
        this.estab = es;
        this.ruas = ru;
        this.telefone = tel;
    }
    @Override
    public View getView(int position, View view, ViewGroup parent) {
        LayoutInflater inflater = context.getLayoutInflater();
        View rowView= inflater.inflate(R.layout.list_estabelecimento, null, true);
        TextView txtEstab = (TextView) rowView.findViewById(R.id.estab_nome);
        TextView txtRua = (TextView) rowView.findViewById(R.id.estab_rua);
        TextView txtTel = (TextView) rowView.findViewById(R.id.estab_tele);

        txtEstab.setText(estab.get(position));
        txtRua.setText(ruas.get(position));
        txtTel.setText(telefone.get(position));

        return rowView;
    }
}
