package com.example.tulio.tcc.Model;

import android.content.ContentValues;

import com.example.tulio.tcc.BD.ComensaDB;
import com.google.gson.annotations.SerializedName;

/**
 * Created by TULIO on 23-Oct-17.
 */

public class ProdutoModel {
    @SerializedName("idProd")
    private int idProd;
    @SerializedName("idEstab")
    private int estab;
    @SerializedName("nome")
    private String nome;
    @SerializedName("preco")
    private String preco;
    @SerializedName("descricao")
    private String descricao;

    public ProdutoModel(int i,int e, String n, String p, String d) {
        idProd = i;
        estab = e;
        nome = n;
        preco = p;
        descricao = d;
    }

    public ProdutoModel(int e, String n, String p, String d) {
        estab = e;
        nome = n;
        preco = p;
        descricao = d;
    }

    public int getEstab() {
        return estab;
    }

    public void setEstab(int estab) {this.estab = estab;}

    public String getNome() {
        return nome;
    }

    public void setNome(String nome) {
        this.nome = nome;
    }

    public String getPreco() {
        return preco;
    }

    public void setPreco(String preco) {
        this.preco = preco;
    }

    public String getDescricao() {
        return descricao;
    }

    public void setDescricao(String descricao) {
        this.descricao = descricao;
    }

    public void inserirBD () {
        ComensaDB bd = null;

        bd = bd.getInstance();

        ContentValues prod = new ContentValues();

        prod.put("IdProduto", idProd);
        prod.put("Estab", estab);
        prod.put("Nome", nome);
        prod.put("Preco", preco);
        prod.put("Descricao", descricao);

        bd.inserir("Produto", prod);
    }
}
