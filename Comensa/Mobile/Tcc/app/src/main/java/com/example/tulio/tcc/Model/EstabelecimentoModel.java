package com.example.tulio.tcc.Model;

import android.content.ContentValues;
import android.database.Cursor;

import com.example.tulio.tcc.BD.ComensaDB;
import com.google.gson.annotations.SerializedName;

import java.util.ArrayList;

/**
 * Created by TULIO on 19-Oct-17.
 */

public class EstabelecimentoModel {

    @SerializedName("idEstab")
    private int idEstab;
    @SerializedName("nome")
    private String nome;
    @SerializedName("telefone")
    private String telefone;
    @SerializedName("idEndereco")
    private int endereco;
    private ArrayList<ProdutoModel> produtos = new ArrayList<ProdutoModel>();
    private ArrayList<PromocaoModel> promocoes = new ArrayList<PromocaoModel>();

    public EstabelecimentoModel (int i) {

        ComensaDB bd = null;
        bd = bd.getInstance();

        Cursor c = bd.buscar("Estabelecimento", new String[]{"Nome", "Telefone", "IdEndereco"}, "IdEstab = '" + i + "'", "");
        c.moveToPosition(0);
        int idN = c.getColumnIndex("Nome");
        int idT = c.getColumnIndex("Telefone");
        int idI = c.getColumnIndex("IdEndereco");

        idEstab = i;
        nome = c.getString(idN);
        telefone = c.getString(idT);
        endereco = c.getInt(idI);

    }

    public EstabelecimentoModel() {}

    public int getIdEstab () {return idEstab;}

    public void setIdEstab (int id) {this.idEstab = id;}

    public String getNome() {
        return nome;
    }

    public void setNome(String nome) {
        this.nome = nome;
    }

    public String getTelefone() {
        return telefone;
    }

    public void setTelefone(String telefone) {
        this.telefone = telefone;
    }

    public int getEndereco() {return endereco;}

    public void setEndereco(int endereco) {
        this.endereco = endereco;
    }

    public ArrayList<ProdutoModel> getProdutos() {
        if(produtos.size() == 0) {
            ComensaDB bd = null;
            bd = bd.getInstance();

            Cursor c = bd.buscar("Produto", new String[]{"Nome", "Preco", "Descricao"}, "Estab = '" + idEstab + "'", "");
            c.moveToPosition(-1);

            while(c.moveToNext()) {
                int idN = c.getColumnIndex("Nome");
                int idP = c.getColumnIndex("Preco");
                int idD = c.getColumnIndex("Descricao");

                ProdutoModel aux = new ProdutoModel(idEstab, c.getString(idN), c.getString(idP), c.getString(idD));
                produtos.add(aux);
            }
        }

        return produtos;
    }

    public ArrayList<PromocaoModel> getPromocoes() {
        if(promocoes.size() == 0) {
            ComensaDB bd = null;
            bd = bd.getInstance();

            Cursor c = bd.buscar("Promocao", new String[]{"Nome", "DataIni", "DataFim", "Descricao"}, "Estab = '" + idEstab + "'", "");
            c.moveToPosition(-1);

            while(c.moveToNext()) {
                int idN = c.getColumnIndex("Nome");
                int idDi = c.getColumnIndex("DataIni");
                int idDf = c.getColumnIndex("DataFim");
                int idD = c.getColumnIndex("Descricao");

                PromocaoModel aux = new PromocaoModel(idEstab, c.getString(idN), c.getString(idDi), c.getString(idDf), c.getString(idD));
                promocoes.add(aux);
            }
        }

        return promocoes;
    }
    
    public void inserirBD () {
        ComensaDB bd = null;

        bd = bd.getInstance();

        ContentValues estab = new ContentValues();

        estab.put("IdEstab", idEstab);
        estab.put("Nome", nome);
        estab.put("Telefone", telefone);
        estab.put("IdEndereco", endereco);

        bd.inserir("Estabelecimento", estab);
    }
}
