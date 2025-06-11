import 'package:app_settings/app_settings.dart';
import 'package:flutter/material.dart';
import 'package:gap/gap.dart';
import 'package:get/get.dart';
import 'package:icons_plus/icons_plus.dart';
import 'package:serbizio_ph/src/features/profile/controllers/profile_controller.dart';
import 'package:serbizio_ph/src/utils/constants/colors.dart';
import 'package:serbizio_ph/src/utils/constants/sizes.dart';
import 'package:serbizio_ph/src/utils/constants/images.dart';
import 'package:serbizio_ph/src/utils/helpers/helper_functions.dart';
import 'package:serbizio_ph/src/utils/theme/app_theme.dart';
import 'account_deletion_page.dart';

class SettingsPage extends StatelessWidget {
  const SettingsPage({super.key});

  @override
  Widget build(BuildContext context) {
    final profileController = Get.put(ProfileController());
    final dark = HelperFunction.isDarkMode(context);
    var size = HelperFunction.screenSize();

    return SafeArea(
      child: Scaffold(
        body: SingleChildScrollView(
          child: Container(
            padding: const EdgeInsets.all(defaultSize),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                const Gap(50.0),
                // Obx(() => Text(userController.user.value.name, style: Theme.of(context).textTheme.headlineSmall)),
                // const Gap(10.0),
                // Obx(
                //   () => Row(
                //     children: [
                //       Text('${userController.user.value.studentId} | Student'),
                //       const Gap(5.0),
                //       const Icon(Icons.verified, size: 16.0, color: activeGreenText,)
                //     ],
                //   ),
                // ),
                // const Gap(40.0),
                // Text('Account', style: TextStyle(fontFamily: 'Epilogue', fontSize: 20.0, fontWeight: FontWeight.bold, color: dark ? whiteColor : blackColor)),
                // const Gap(10.0),
                // const Divider(color: borderColor),
                // ListTile(
                //   leading: Icon(MingCute.user_3_line, color: dark ? whiteColor : textColor1),
                //   title: const Text('Personal information'),
                //   trailing: Icon(Icons.arrow_forward_ios_outlined, size: 14.0, color: dark ? whiteColor : textColor1),
                //   onTap: () {Get.to(() => const ProfileEditPage());},
                // ),
                // const Divider(color: borderColor, indent: 70.0),
                // ListTile(
                //   leading: Icon(Icons.nfc_outlined, color: dark ? whiteColor : textColor1),
                //   title: const Text('RFID'),
                //   trailing: Icon(Icons.arrow_forward_ios_outlined, size: 14.0, color: dark ? whiteColor : textColor1),
                //   onTap: () {Get.to(() => const RFIDPage());},
                // ),
                // const Divider(color: borderColor, indent: 70.0),
                // const Gap(30.0),

                Text('Settings', style: TextStyle(fontFamily: 'Epilogue', fontSize: 20.0, fontWeight: FontWeight.bold, color: dark ? whiteColor : blackColor)),
                const Gap(10.0),
                const Divider(color: borderColor, indent: 70.0),
                ListTile(
                  leading: Icon(dark ? MingCute.moon_line : MingCute.sun_line, color: dark ? whiteColor : textColor1),
                  title: const Text('Theme'),
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
                const Gap(10.0),
                const Divider(color: borderColor, indent: 70.0),
                ListTile(
                  leading: Icon(dark ? MingCute.moon_line : MingCute.user_visible_line, color: dark ? whiteColor : textColor1),
                  title: const Text('Login'),
                  trailing: Icon(Icons.arrow_forward_ios_outlined, size: 14.0, color: dark ? whiteColor : textColor1),
                ),
                const Divider(color: borderColor, indent: 70.0),
                ListTile(
                  leading: Icon(MingCute.user_remove_2_line, color: dark ? whiteColor : textColor1),
                  title: const Text('Account Deletion'),
                  trailing: Icon(Icons.arrow_forward_ios_outlined, size: 14.0, color: dark ? whiteColor : textColor1),
                  onTap: () => Get.to(() => const UserAccountMenuPage()),
                ),
                const Divider(color: borderColor, indent: 70.0),
                const Gap(30.0),
                Text('Support', style: TextStyle(fontFamily: 'Epilogue', fontSize: 20.0, fontWeight: FontWeight.bold, color: dark ? whiteColor : blackColor)),
                const Gap(10.0),
                const Divider(color: borderColor),
                ListTile(
                  leading: Icon(MingCute.information_line, color: dark ? whiteColor : textColor1),
                  title: const Text('About'),
                  trailing: Icon(Icons.arrow_forward_ios_outlined, size: 14.0, color: dark ? whiteColor : textColor1),
                  onTap: () {
                    showAboutDialog(
                      context: context,
                      applicationName: profileController.appInfo.value.appName,
                      applicationVersion: '${profileController.appInfo.value.version} (${profileController.appInfo.value.buildNumber})',
                      applicationLegalese: 'Serbizio PH Mobile Application\n\n© ${DateTime.now().year}',
                      applicationIcon: Padding(
                        padding: const EdgeInsets.only(top: 10.0, bottom: 10.0),
                        child: Image(
                          image: const AssetImage(appLogo),
                          height: size.height * 0.05,
                        ),
                      ),
                    );
                  },
                ),
                const Divider(color: borderColor, indent: 70.0),
                ListTile(
                  leading: Icon(Icons.privacy_tip_outlined, color: dark ? whiteColor : textColor1),
                  title: const Text('Privacy Policy'),
                  trailing: Icon(Icons.arrow_forward_ios_outlined, size: 14.0, color: dark ? whiteColor : textColor1),
                  onTap: () => AppSettings.openAppSettings(type: AppSettingsType.notification),
                ),
                const Divider(color: borderColor, indent: 70.0),
                ListTile(
                  leading: Icon(MingCute.file_info_line, color: dark ? whiteColor : textColor1),
                  title: const Text('Terms and Condition'),
                  trailing: Icon(Icons.arrow_forward_ios_outlined, size: 14.0, color: dark ? whiteColor : textColor1),
                  onTap: () => AppSettings.openAppSettings(type: AppSettingsType.notification),
                ),
                const Divider(color: borderColor, indent: 70.0),
                const Gap(30.0),

                Align(
                  alignment: Alignment.bottomCenter,
                  child: Center(
                    child: Column(
                      children: [
                        Obx(
                          () => Text(
                            '${profileController.appInfo.value.appName}\nv${profileController.appInfo.value.version}',
                            textAlign: TextAlign.center,
                            style: const TextStyle(fontSize: 16.0, color: primaryColor, fontWeight: FontWeight.bold)
                          ),
                        ),
                      ],
                    ),
                  ),
                )
              ],
            ),
          ),
        ),
      ),
    );
  }
}
