import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:get/get.dart';
import 'package:serbizio_ph_web_privacy_policy/src/features/user/privacy_policy_page.dart';
import 'package:serbizio_ph_web_privacy_policy/src/utils/theme/app_theme.dart';

Future<void> main() async {
  WidgetsFlutterBinding.ensureInitialized();

  // await Firebase.initializeApp(options: DefaultFirebaseOptions.android).then(
  //   (FirebaseApp value) => Get.put(AuthenticationRepository())
  // );

  // To make sure app always portrait up
  await SystemChrome.setPreferredOrientations(
    [DeviceOrientation.portraitUp]
  ).then((value) => runApp(const MainApp()));
}

class MainApp extends StatelessWidget {
  const MainApp({super.key});
  @override
  Widget build(BuildContext context) {
    return GetMaterialApp(
      debugShowCheckedModeBanner: false,
      theme: AppTheme.lightTheme,
      darkTheme: AppTheme.darkTheme,
      themeMode: ThemeMode.light,
      // initialBinding: GeneralBindings(),
      home: const PrivacyPolicy(),
    );
  }
}
