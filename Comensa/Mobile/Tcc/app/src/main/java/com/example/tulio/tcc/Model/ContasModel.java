package com.example.tulio.tcc.Model;

import android.content.ContentValues;
import android.util.Log;

import com.example.tulio.tcc.BD.ComensaDB;
import com.google.gson.annotations.SerializedName;

/**
 * Created by TULIO on 20-Oct-17.
 */

public class ContasModel {
    @SerializedName("saldo")
    private String saldo;
    @SerializedName("idEstab")
    private int estab;
    @SerializedName("idMensa")
    private int mensa;

    public ContasModel(int e, int m, String s) {
        estab = e;
        mensa = m;
        saldo = s;
    }

    public ContasModel () {
        saldo = "0";
    }

    public String getSaldo() {
        return saldo;
    }

    public void setSaldo(String saldo) {
        this.saldo = saldo;
    }

    public int getEstab() {
        return estab;
    }

    public void setEstab(int estab) {
        this.estab = estab;
    }

    public int getMensa() {
        return mensa;
    }

    public void setMensa(int mensa) {
        this.mensa = mensa;
    }

    public void inserirBd() {
        ComensaDB bd = null;
        bd = bd.getInstance();
        ContentValues conta = new ContentValues();

        conta.put("Saldo", saldo);
        conta.put("Estab", estab);
        conta.put("Mensa", mensa);

        bd.inserir("Contas", conta);
    }
}
