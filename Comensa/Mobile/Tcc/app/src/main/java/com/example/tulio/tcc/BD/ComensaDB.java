package com.example.tulio.tcc.BD;

import android.content.ContentValues;
import android.content.Context;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.util.Log;

/**
 * Created by TULIO on 04-Sep-17.
 */

public class ComensaDB {

    protected SQLiteDatabase db;
    private final String NOME_BANCO = "comensaDB";
    private static ComensaDB INSTANCE = new ComensaDB();

    private final String[] SCRIPT_DATABASE_CREATE = new String[] {
            "CREATE TABLE Endereco (" +
                    "IdEndereco INTEGER PRIMARY KEY," +
                    "Bairro TEXT NOT NULL," +
                    "Rua TEXT NOT NULL," +
                    "Numero INTEGER NOT NULL," +
                    "Complemento TEXT," +
                    "CEP TEXT NOT NULL);",

            "CREATE TABLE Estabelecimento (" +
                    "IdEstab INTEGER PRIMARY KEY," +
                    "Nome TEXT NOT NULL," +
                    "Telefone TEXT NOT NULL," +
                    "IdEndereco INTEGER NOT NULL," +
                    "CONSTRAINT fk_Estabelecimento_Endereco FOREIGN KEY (IdEndereco) REFERENCES Endereco(IdEndereco));",

            "CREATE TABLE Mensalista (" +
                    "IdMensa INTEGER PRIMARY KEY," +
                    "UserMensa TEXT NOT NULL," +
                    "CPF TEXT NOT NULL," +
                    "Senha TEXT NOT NULL," +
                    "TemSessao TEXT NOT NULL);",

            "CREATE TABLE Contas (" +
                    "Saldo TEXT NOT NULL," +
                    "Estab INTEGER NOT NULL," +
                    "Mensa INTEGER NOT NULL," +
                    "PRIMARY KEY  (Estab,Mensa)," +
                    "CONSTRAINT fk_Contas_Estabelecimento FOREIGN KEY (Estab) REFERENCES Estabelecimento (IdEstab)," +
                    "CONSTRAINT fk_Contas_Mensalista FOREIGN KEY (Mensa) REFERENCES Mensalista (IdMensa));",

            "CREATE TABLE Produto(" +
                    "IdProduto INTEGER NOT NULL," +
                    "Estab INTEGER NOT NULL," +
                    "Nome TEXT NOT NULL," +
                    "Preco TEXT NOT NULL," +
                    "Descricao TEXT," +
                    "PRIMARY KEY  (Estab,IdProduto)," +
                    "CONSTRAINT fk_Produto_Estabelecimento FOREIGN KEY (Estab) REFERENCES Estabelecimento (IdEstab));",

            "CREATE TABLE Promocao(" +
                    "IdPromocao INTEGER NOT NULL," +
                    "Estab INTEGER NOT NULL," +
                    "Nome TEXT NOT NULL," +
                    "DataIni TEXT NOT NULL," +
                    "DataFim TEXT NOT NULL," +
                    "Descricao TEXT," +
                    "PRIMARY KEY  (Estab,IdPromocao)," +
                    "CONSTRAINT fk_Promocao_Estabelecimento FOREIGN KEY (Estab) REFERENCES Estabelecimento (IdEstab));"
    };

    public ComensaDB(){
        Context ctx = MyApp.getAppContext();

        db = ctx.openOrCreateDatabase(NOME_BANCO,Context.MODE_PRIVATE,null);

        Cursor c = buscar("sqlite_master", null, "type = 'table'", "");

        if(c.getCount() == 1){
            for(int i = 0; i < SCRIPT_DATABASE_CREATE.length; i++) {
                db.execSQL(SCRIPT_DATABASE_CREATE[i]);
            }
            Log.i("BANCO_DADOS", "Criou tabelas do banco e as populou.");
        }

        c.close();
        Log.i("BANCO_DADOS", "Abriu conexão com o banco.");
    }

    public long inserir(String tabela, ContentValues valores) {
        long id = db.insert(tabela, null, valores);
        Log.i("BANCO_DADOS", "Cadastrou registro com o id [" + id + "]");
        return id;
    }

    public int atualizar(String tabela, ContentValues valores, String where) {
        int count = db.update(tabela, valores, where, null);
        Log.i("BANCO_DADOS", "Atualizou [" + count + "] registros");
        return count;
    }

    public int deletar(String tabela, String where) {
        int count = db.delete(tabela, where, null);
        Log.i("BANCO_DADOS", "Deletou [" + count + "] registros");
        return count;
    }

    public Cursor buscar(String tabela, String colunas[], String where, String orderBy) {
        Cursor c;
        if(!where.equals(""))
            c = db.query(tabela, colunas, where, null, null, null, orderBy);
        else
            c = db.query(tabela, colunas, null, null, null, null, orderBy);
        Log.i("BANCO_DADOS", "Realizou uma busca e retornou [" + c.getCount() + "] registros.");
        return c;
    }

    public void abrir(Context ctx) {
        db = ctx.openOrCreateDatabase(NOME_BANCO, Context.MODE_PRIVATE, null);
        Log.i("BANCO_DADOS", "Abriu conexão com o banco.");
    }

    public static ComensaDB getInstance(){
        return INSTANCE;
    }

    public void fechar() {
        if (db != null) {
            db.close();
            Log.i("BANCO_DADOS", "Fechou conexão com o Banco.");
        }
    }
}
