import java.util.*;
public class array_2d
{
public static void main(String args[])
{
Scanner sc=new Scanner(System.in);
int row=sc.nextInt();
int col=sc.nextInt();
int arr[][]=new int[row][col];
System.out.println("enter the values");
for(int i=0;i<row;i++)
{
for(int j=0;j<col;j++)
{
arr[i][j]=sc.nextInt();
}
}
System.out.println("entered values");
for (int i=0;i<row;i++)
{
for(int j=0;j<row;i++)
{
System.out.print(arr[i][j]+"\t");
}
System.out.println();
}
}
}
