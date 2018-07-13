package com.example.tulio.tcc.Model;

import android.content.ContentValues;
import android.database.Cursor;

import com.example.tulio.tcc.BD.ComensaDB;
import com.example.tulio.tcc.Model.ContasModel;
import com.google.gson.annotations.SerializedName;

import java.util.ArrayList;

/**
 * Created by TULIO on 19-Oct-17.
 */

public class MensalistaModel {
    @SerializedName("idMensa")
    private int idMensa;
    @SerializedName("userMensa")
    private String UserMensa;
    @SerializedName("CPF")
    private String CPF;
    @SerializedName("senha")
    private String Senha;
    private boolean temSessao;
    private ArrayList<ContasModel> contas = new ArrayList<ContasModel>();

    public MensalistaModel (String user, String c, String s, boolean tem) {
        UserMensa = user;
        CPF = c;
        Senha = s;
        temSessao = tem;
    }

    public MensalistaModel() {
        ComensaDB bd = null;

        bd = bd.getInstance();

        Cursor c = bd.buscar("Mensalista", new String[]{"IdMensa","UserMensa", "CPF", "Senha"}, "TemSessao = 'sim'", "");

        if(c.getCount() != 0) {
            c.moveToPosition(0);
            int idI = c.getColumnIndex("IdMensa");
            int idU = c.getColumnIndex("UserMensa");
            int idC = c.getColumnIndex("CPF");
            int idS = c.getColumnIndex("Senha");

            idMensa = Integer.parseInt(c.getString(idI));
            UserMensa = c.getString(idU);
            CPF = c.getString(idC);
            Senha = c.getString(idS);
            temSessao = true;

            c = bd.buscar("Contas", new String[]{"Estab", "Saldo"}, "Mensa = '" + idMensa + "'", "");
            c.moveToPosition(-1);
            while(c.moveToNext()) {
                int idEs = c.getColumnIndex("Estab");
                int idSa = c.getColumnIndex("Saldo");
                ContasModel conta = new ContasModel(Integer.parseInt(c.getString(idEs)), idMensa, c.getString(idSa));
                contas.add(conta);
            }
        }
        else {
            temSessao = false;
        }
    }

    public int getIdMensa() {return idMensa;}

    public void setIdMensa(int i) {this.idMensa = i;}

    public String getUserMensa() {return UserMensa;}

    public void setUserMensa(String UserMensa) {
        this.UserMensa = UserMensa;
    }

    public String getCPF() {
        return CPF;
    }

    public void setCPF(String CPF) {
        this.CPF = CPF;
    }

    public String getSenha() {
        return Senha;
    }

    public void setSenha(String Senha) {
        this.Senha = Senha;
        ComensaDB bd = null;
        bd = bd.getInstance();
        ContentValues values = new ContentValues();
        values.put("Senha", Senha);
        bd.atualizar("Mensalista", values, "TemSessao = 'sim'");
    }

    public boolean isTemSessao() {
        return temSessao;
    }

    public void setTemSessao(boolean temSessao) {
        this.temSessao = temSessao;
        ComensaDB bd = null;
        bd = bd.getInstance();
        ContentValues values = new ContentValues();
        values.put("TemSessao", "nao");
        bd.atualizar("Mensalista", values, "TemSessao = 'sim'");
    }

    public ArrayList<ContasModel> getContas() {
        return contas;
    }

    public ContasModel getConta(int e) {
        for(int i=0;i<contas.size();i++) {
            if(contas.get(i).getEstab() == e) {
                return contas.get(i);
            }
        }
        return null;
    }

    public void addContas(ContasModel c) {contas.add(c);}

    public void deleteContas(int e) {
        for(int i=0;i<contas.size();i++) {
            if(contas.get(i).getEstab() == e) {
                contas.remove(i);
            }
        }
    }

    public void inserirBd () {
        ComensaDB bd = null;

        bd = bd.getInstance();

        ContentValues cliente = new ContentValues();

        cliente.put("IdMensa", idMensa);
        cliente.put("UserMensa", UserMensa);
        cliente.put("CPF", CPF);
        cliente.put("Senha", Senha);
        cliente.put("TemSessao", "sim");

        bd.inserir("Mensalista", cliente);
    }
}
