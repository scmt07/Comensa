package com.example.tulio.tcc.BD;

import android.app.Application;
import android.content.Context;
import android.util.Log;

/**
 * Created by TULIO on 04-Sep-17.
 */

public class MyApp extends Application {
    private static Context context;

    public void onCreate() {
        super.onCreate();
        MyApp.context = getApplicationContext();
        Log.i("BANCO_DADOS", "Passei aqui" + MyApp.context);
    }
    public static Context getAppContext() {
        // Método usado para recuperar o context do app
        // de qualquer parte do programa
        return MyApp.context;
    }
}
