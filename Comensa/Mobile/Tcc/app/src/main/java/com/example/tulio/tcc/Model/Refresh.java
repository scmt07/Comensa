package com.example.tulio.tcc.Model;

import com.google.gson.annotations.SerializedName;

import java.util.ArrayList;

/**
 * Created by TULIO on 11-Jun-18.
 */

public class Refresh {
    @SerializedName("contas")
    private ArrayList<ContasModel> contas;
    @SerializedName("estabs")
    private ArrayList<EstabelecimentoModel> estabs;
    @SerializedName("enderecos")
    private ArrayList<EnderecoModel> ends;
    @SerializedName("produtos")
    private ArrayList<ProdutoModel> prods;
    @SerializedName("promocoes")
    private ArrayList<PromocaoModel> proms;

    public Refresh() {}

    public void inserirBd() {
        for(ContasModel c:contas)
            c.inserirBd();
        for(EstabelecimentoModel e:estabs)
            e.inserirBD();
        for(EnderecoModel e:ends)
            e.inserirBD();
        for(ProdutoModel p:prods)
            p.inserirBD();
        for(PromocaoModel p:proms)
            p.inserirBD();
    }
}
