import 'package:app_settings/app_settings.dart';
import 'package:flutter/material.dart';
import 'package:gap/gap.dart';
import 'package:get/get.dart';
import 'package:icons_plus/icons_plus.dart';
import 'package:serbizio_ph/src/features/profile/controllers/profile_controller.dart';
import 'package:serbizio_ph/src/utils/constants/colors.dart';
import 'package:serbizio_ph/src/utils/constants/sizes.dart';
import 'package:serbizio_ph/src/utils/helpers/helper_functions.dart';
import 'package:serbizio_ph/src/utils/theme/app_theme.dart';

class UserAccountMenuPage extends StatelessWidget {
  const UserAccountMenuPage({super.key});

  @override
  Widget build(BuildContext context) {
    final profileController = Get.put(ProfileController());
    final dark = HelperFunction.isDarkMode(context);
    return SafeArea(
      child: Scaffold(
        body: SingleChildScrollView(
          child: Container(
            padding: const EdgeInsets.all(defaultSize),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                const Gap(50.0),
                Text('User Account', style: TextStyle(fontFamily: 'Epilogue', fontSize: 20.0, fontWeight: FontWeight.bold, color: dark ? whiteColor : blackColor)),
                const Gap(10.0),
                const Divider(color: borderColor, indent: 70.0),
                ListTile(
                  leading: Icon(MingCute.user_1_fill, color: dark ? whiteColor : textColor1),
                  title: const Text('Account Deletion'),
                  trailing: Icon(Icons.arrow_forward_ios_outlined, size: 14.0, color: dark ? whiteColor : textColor1),
                  onTap: () => AppSettings.openAppSettings(type: AppSettingsType.notification),
                ),
                const Divider(color: borderColor, indent: 70.0),
                ListTile(
                  leading: Icon(dark ? MingCute.moon_line : MingCute.sun_line, color: dark ? whiteColor : textColor1),
                  title: const Text('Login'),
                  trailing: Obx(
                        () => Switch(
                      activeColor: primaryColor,
                      inactiveThumbColor: primaryColor,
                      inactiveTrackColor: secondaryColor,
                      value: profileController.switchTheme.value,
                      onChanged: (value) {
                        profileController.switchTheme.value = !profileController.switchTheme.value;
                        profileController.switchTheme.value ? Get.changeTheme(AppTheme.darkTheme) : Get.changeTheme(AppTheme.lightTheme);
                      },
                    ),
                  ),
                ),
              ],
            ),
          ),
        ),
      ),
    );
  }
}
