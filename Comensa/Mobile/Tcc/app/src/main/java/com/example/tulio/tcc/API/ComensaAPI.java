package com.example.tulio.tcc.API;

import com.example.tulio.tcc.Model.ContasModel;
import com.example.tulio.tcc.Model.EnderecoModel;
import com.example.tulio.tcc.Model.EstabelecimentoModel;
import com.example.tulio.tcc.Model.MensalistaModel;
import com.example.tulio.tcc.Model.ProdutoModel;
import com.example.tulio.tcc.Model.PromocaoModel;
import com.example.tulio.tcc.Model.Refresh;
import com.google.gson.Gson;
import com.google.gson.GsonBuilder;

import java.util.ArrayList;


import retrofit2.Call;
import retrofit2.Retrofit;
import retrofit2.adapter.rxjava.RxJavaCallAdapterFactory;
import retrofit2.converter.gson.GsonConverterFactory;
import rx.Observable;

import retrofit2.http.Body;
import retrofit2.http.Field;
import retrofit2.http.FormUrlEncoded;
import retrofit2.http.GET;
import retrofit2.http.POST;
import retrofit2.http.Query;


/**
 * Created by TULIO on 01-May-18.
 */

public interface ComensaAPI {

    public static Gson gson = new GsonBuilder()
            .setLenient()
            .create();

    /*public static final Retrofit retrofit = new Retrofit.Builder()
            .baseUrl("http://192.168.1.104")
            .addConverterFactory(GsonConverterFactory.create(gson))
            .build();*/

    public static final Retrofit retrofit = new Retrofit.Builder()
            //.baseUrl("http://192.168.1.104")
            .baseUrl("http://10.0.2.2")
            .addConverterFactory(GsonConverterFactory.create(gson))
            .addCallAdapterFactory(RxJavaCallAdapterFactory.create())
            .build();


    @FormUrlEncoded
    @POST("/comensa/app/registerMensa.php")
    Call<String> insertMensa(@Field("bairro") String bairro, @Field("rua") String rua, @Field("nume") int nume,
                             @Field("comple") String comple, @Field("cep") String cep, @Field("nome") String nome, @Field("cpf") String cpf,
                             @Field("tele") String tele, @Field("email") String email, @Field("usua") String usua, @Field("senha") String senha);

    @FormUrlEncoded
    @POST("/comensa/app/trocaSenha.php")
    Call<String> trocaSenha(@Field("senha") String senha, @Field("idMensa") int idMensa);

    @GET("/comensa/app/verificaUsuario.php")
    Observable<MensalistaModel> verUsuario (@Query("user") String user, @Query("senha") String senha);

    @GET("/comensa/app/iniciando.php")
    Observable<Refresh> iniciando(@Query("idMensa") int idMensa);
}
