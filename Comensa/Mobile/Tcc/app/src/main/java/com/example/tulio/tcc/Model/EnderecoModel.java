package com.example.tulio.tcc.Model;

import android.content.ContentValues;
import android.database.Cursor;

import com.example.tulio.tcc.BD.ComensaDB;
import com.google.gson.annotations.SerializedName;

/**
 * Created by TULIO on 19-Oct-17.
 */

public class EnderecoModel {

    @SerializedName("idEndereco")
    private int idEndereco;
    @SerializedName("bairro")
    private String bairro;
    @SerializedName("rua")
    private String rua;
    @SerializedName("numero")
    private int numero;
    @SerializedName("complemento")
    private String complemento;
    @SerializedName("CEP")
    private String cep;

    public EnderecoModel (String b, String r, int n, String com, String c){

        bairro = b;
        rua = r;
        numero = n;
        complemento = com;
        cep = c;
    }

    public EnderecoModel(int id) {

        ComensaDB bd = null;

        bd = bd.getInstance();

        final Cursor c = bd.buscar("Endereco", new String[]{"Bairro", "Rua", "Numero", "Complemento", "CEP"}, "IdEndereco = '" + id + "'", "");
        c.moveToPosition(0);
        int idB = c.getColumnIndex("Bairro");
        int idR = c.getColumnIndex("Rua");
        int idN = c.getColumnIndex("Numero");
        int idC = c.getColumnIndex("Complemento");
        int idCep = c.getColumnIndex("CEP");

        idEndereco = id;
        bairro = c.getString(idB);
        rua = c.getString(idR);
        numero = c.getInt(idN);
        complemento = c.getString(idC);
        cep = c.getString(idCep);
    }

    public int getIdEndereco() {
        return idEndereco;
    }

    public String getBairro () {
        return bairro;
    }

    public void setBairro (String b) {
        bairro = b;
    }

    public String getRua() {
        return rua;
    }

    public void setRua(String r) {
        rua = r;
    }

    public int getNumero(){
        return numero;
    }

    public void setNumero(int n){
        numero = n;
    }

    public void setComplemento (String c) {
        bairro = c;
    }

    public String getComplemento() {
        return complemento;
    }

    public void setCep (String c) {
        bairro = c;
    }

    public String getCep() {
        return cep;
    }
    
    public void inserirBD () {
        ComensaDB bd = null;

        bd = bd.getInstance();

        ContentValues end = new ContentValues();

        end.put("IdEndereco", idEndereco);
        end.put("Bairro", bairro);
        end.put("Rua", rua);
        end.put("Numero", numero);
        end.put("Complemento", complemento);
        end.put("CEP", cep);

        bd.inserir("Endereco", end);
    }
}
