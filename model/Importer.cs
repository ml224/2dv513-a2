using System;
using System.Text;
using System.IO;
using ICSharpCode.SharpZipLib.Core;
using ICSharpCode.SharpZipLib.BZip2;

namespace _2dv513_a2
{
    class Importer
    {
        public void writeSomething()
        {
            System.Console.WriteLine("Working!");
            readBz2();
        }

        public void readBz2(){
            string fileToBeDecompressed = @"C:\Users\Malin\Source\Repos\2dv513\a2\2dv513-a2\data\RC_2007-10.bz2";
            BZip2InputStream bz2 = new BZip2InputStream(File.OpenRead(fileToBeDecompressed));

            try{
                using(BZip2InputStream sr = bz2)//new StreamReader(fileToBeDecompressed))
                {
                    int line;
                    int count = 1;
                    while((line = sr.ReadByte()) != -1 && count < 5)
                    {
                        Console.WriteLine(line);
                        count ++;
                    }
                }
            }
            catch(Exception e)
            {
                Console.WriteLine("The file could not be read: ");
                Console.WriteLine(e.Message);                
            }            
        }
    }
}