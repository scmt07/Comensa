package com.example.tulio.tcc.Model;

import android.content.ContentValues;

import com.example.tulio.tcc.BD.ComensaDB;
import com.google.gson.annotations.SerializedName;

import java.net.PortUnreachableException;

/**
 * Created by TULIO on 23-Oct-17.
 */

public class PromocaoModel {
    @SerializedName("idPromo")
    private int idPromo;
    @SerializedName("idEstab")
    private int estab;
    @SerializedName("nome")
    private String nome;
    @SerializedName("dataIni")
    private String data_ini;
    @SerializedName("dataFim")
    private String data_fim;
    @SerializedName("descricao")
    private String descricao;

    public PromocaoModel(int i,int e, String n, String di, String df, String d) {
        idPromo = i;
        estab = e;
        nome = n;
        data_ini = di;
        data_fim = df;
        descricao = d;
    }

    public PromocaoModel(int e, String n, String di, String df, String d) {
        estab = e;
        nome = n;
        data_ini = di;
        data_fim = df;
        descricao = d;
    }

    public int getEstab() {
        return estab;
    }

    public String getNome() {
        return nome;
    }

    public String getData_ini() {
        return data_ini;
    }

    public String getData_fim() {
        return data_fim;
    }

    public String getDescricao() {
        return descricao;
    }

    public void inserirBD () {
        ComensaDB bd = null;

        bd = bd.getInstance();

        ContentValues promo = new ContentValues();

        promo.put("IdPromocao", idPromo);
        promo.put("Estab", estab);
        promo.put("Nome", nome);
        promo.put("DataIni", data_ini);
        promo.put("DataFim", data_fim);
        promo.put("Descricao", descricao);

        bd.inserir("Promocao", promo);
    }
}
