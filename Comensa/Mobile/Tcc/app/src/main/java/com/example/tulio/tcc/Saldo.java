package com.example.tulio.tcc;

import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import com.example.tulio.tcc.Model.ContasModel;
import com.example.tulio.tcc.Model.MensalistaModel;

import java.util.ArrayList;

/**
 * Created by TULIO on 21-Oct-17.
 */

public class Saldo extends Fragment {
    private MensalistaModel usuario;
    TextView saldo;

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {

        View view = inflater.inflate(R.layout.saldo, container, false);
        DetalhesActivity activity = (DetalhesActivity) getActivity();
        int estab = activity.estab;

        ContasModel aux = new ContasModel();

        usuario = new MensalistaModel();
        ArrayList<ContasModel> contas = usuario.getContas();
        for(int i=0;i<contas.size();i++) {
            if(contas.get(i).getEstab() == estab)
                aux = contas.get(i);
        }

        saldo = (TextView) view.findViewById(R.id.viewSaldo);
        saldo.setText(aux.getSaldo());

        return view;
    }
}
